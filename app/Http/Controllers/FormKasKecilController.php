<?php

namespace App\Http\Controllers;

use App\Models\KasBesar;
use App\Models\KasKecil;
use App\Models\Rekening;
use App\Models\GroupWa;
use App\Services\StarSender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormKasKecilController extends Controller
{
    public function masuk()
    {
        $db = new KasBesar();
        $nomor = $db->generateNomorKasKecil();
        $rekening = Rekening::where('untuk', 'kas-kecil')->first();

        return view('billing.kas-kecil.masuk', [
            'nomor' => $nomor,
            'rekening' => $rekening,
        ]);
    }

    public function masuk_store()
    {
        $db = new KasKecil();
        $kasBesar = new KasBesar();
        $saldo = $kasBesar->lastKasBesar()->saldo ?? 0;

        if ($saldo < 1000000) {
            return redirect()->route('billing')->with('error', 'Saldo Kas Besar tidak mencukupi');
        }

        DB::beginTransaction();

        $store = $kasBesar->insertKasKecil();
        $store2 = $db->insertMasuk($store->nomor_kas_kecil);

        $group = GroupWa::where('untuk', 'kas-besar')->first();

        $pesan =    "🔴🔴🔴🔴🔴🔴🔴🔴🔴\n".
                    "*Form Permintaan Kas Kecil*\n".
                    "🔴🔴🔴🔴🔴🔴🔴🔴🔴\n\n".
                    "*KK".sprintf("%02d",$store->nomor_kas_kecil)."*\n\n".
                    "Nilai : *Rp. 1.000.000,-*\n\n".
                    "Ditransfer ke rek:\n\n".
                    "Bank      : ".$store->bank."\n".
                    "Nama     : ".$store->nama_rek."\n".
                    "No. Rek : ".$store->no_rek."\n\n".
                    "==========================\n".
                    "Sisa Saldo Kas Besar : \n".
                    "Rp. ".number_format($store->saldo, 0, ',', '.')."\n\n".
                    "Sisa Saldo Kas Kecil : \n".
                    "Rp. ".number_format($store2->saldo, 0, ',', '.')."\n\n".
                    "Terima kasih 🙏🙏🙏\n";
        $send = new StarSender($group->nama_group, $pesan);
        $res = $send->sendGroup();

        DB::commit();

        return redirect()->route('billing')->with('success', 'Data berhasil disimpan');
    }

    public function keluar()
    {
        return view('billing.kas-kecil.keluar');
    }

    public function keluar_store(Request $request)
    {
        $data = $request->validate([
            'nominal_transaksi' => 'required',
            'uraian' => 'required',
            'tipe' => 'required',
            'nama_rek' => 'nullable',
            'no_rek' => 'nullable',
            'bank' => 'nullable',
        ]);

        if ($data['tipe'] == 1) {
            $data['nama_rek'] = "Cash";
        }

        unset($data['tipe']);

        $db = new KasKecil();

        $nominal = str_replace('.', '', $data['nominal_transaksi']);

        $saldo = $db->lastKasKecil()->saldo ?? 0;

        if ($saldo < $nominal) {
            return redirect()->back()->with('error', 'Saldo Kas Kecil tidak mencukupi');
        }

        DB::beginTransaction();

        $store = $db->insertKeluar($data);

        $group = GroupWa::where('untuk', 'team')->first();

        if ($data['nama_rek'] == 'Cash') {
            $pesan =    "==========================\n".
                        "*Form Pengeluaran Kas Kecil*\n".
                        "==========================\n\n".
                        "Uraian: ".$store->uraian."\n\n".
                        "Nilai : *Rp. ".$store->nf_nominal_transaksi."*\n\n".
                        "Cash\n\n".
                        "==========================\n".
                        "Sisa Saldo Kas Kecil : \n".
                        "Rp. ".$store->nf_saldo."\n\n".
                        "Terima kasih 🙏🙏🙏\n";
        } else {
            $pesan =    "==========================\n".
                        "*Form Pengeluaran Kas Kecil*\n".
                        "==========================\n\n".
                        "Uraian: ".$store->uraian."\n\n".
                        "Nilai : *Rp. ".$store->nf_nominal_transaksi."*\n\n".
                        "Ditransfer ke rek:\n\n".
                        "Bank     : ".$store->bank."\n".
                        "Nama    : ".$store->nama_rek."\n".
                        "No. Rek : ".$store->no_rek."\n\n".
                        "==========================\n".
                        "Sisa Saldo Kas Kecil : \n".
                        "Rp. ".$store->nf_saldo."\n\n".
                        "Terima kasih 🙏🙏🙏\n";
        }

        $send = new StarSender($group->nama_group, $pesan);
        $res = $send->sendGroup();

        DB::commit();

        return redirect()->route('billing')->with('success', 'Data berhasil disimpan');
    }

    public function void(KasKecil $id)
    {
        $db = new KasKecil();

        DB::beginTransaction();
        $db->insertVoid($id->id);
        DB::commit();

        return redirect()->route('rekap.kas-kecil')->with('success', 'Data berhasil di Void');
    }
}
