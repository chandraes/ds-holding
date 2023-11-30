<?php

namespace App\Http\Controllers;

use App\Models\KasBesar;
use App\Models\Rekening;
use App\Models\KasSupplier;
use App\Models\Transaksi;
use App\Models\InvoicePpn;
use App\Services\StarSender;
use App\Models\GroupWa;
use Illuminate\Http\Request;

class FormDepositController extends Controller
{
    public function index()
    {
        $db = new KasBesar();
        $nomor = $db->nomorDeposit();

        $rekening = Rekening::where('untuk', 'kas-besar')->first();

        return view('billing.form-deposit.masuk', [
            'rekening' => $rekening,
            'nomor' => $nomor
        ]);
    }

    public function masuk_store(Request $request)
    {
        $data = $request->validate([
            'nominal_transaksi' => 'required',
        ]);

        $kasBesar = new KasBesar();

        $store = $kasBesar->insertDeposit($data);

        $group = GroupWa::where('untuk', 'kas-besar')->first();
        $pesan =    "🔵🔵🔵🔵🔵🔵🔵🔵🔵\n".
                    "*Form Permintaan Deposit*\n".
                    "🔵🔵🔵🔵🔵🔵🔵🔵🔵\n\n".
                    "*D".$store->nomor_deposit."*\n\n".
                    "Nilai :  *Rp. ".number_format($data['nominal_transaksi'], 0, ',', '.')."*\n\n".
                    "Ditransfer ke rek:\n\n".
                    "Bank      : ".$data['bank']."\n".
                    "Nama    : ".$data['nama_rek']."\n".
                    "No. Rek : ".$data['no_rek']."\n\n".
                    "==========================\n".
                    "Sisa Saldo Kas Besar : \n".
                    "Rp. ".number_format($store->saldo, 0, ',', '.')."\n\n".
                    "Total Modal Investor : \n".
                    "Rp. ".number_format($store->modal_investor_terakhir, 0, ',', '.')."\n\n".
                    "Terima kasih 🙏🙏🙏\n";
        $send = new StarSender($group->nama_group, $pesan);
        $res = $send->sendGroup();

        return redirect()->route('billing')->with('success', 'Berhasil menambahkan data');
    }

    public function keluar()
    {
        $rekening = Rekening::where('untuk', 'withdraw')->first();

        return view('billing.form-deposit.keluar', [
            'rekening' => $rekening
        ]);
    }

    public function keluar_store(Request $request)
    {
        $data = $request->validate([
            'nominal_transaksi' => 'required',
        ]);

        $kasBesar = new KasBesar;
        $last = $kasBesar->lastKasBesar();

        if($last == null || $last->saldo < $data['nominal_transaksi']){

            return redirect()->back()->with('error', 'Saldo Kas Besar Tidak Cukup');

        }

        $store = $kasBesar->insertWithdraw($data);

        $group = GroupWa::where('untuk', 'kas-besar')->first();

        $pesan =    "🔴🔴🔴🔴🔴🔴🔴🔴🔴\n".
                    "*Form Pengembalian Deposit*\n".
                    "🔴🔴🔴🔴🔴🔴🔴🔴🔴\n\n".
                    "Nilai :  *Rp. ".number_format($data['nominal_transaksi'], 0, ',', '.')."*\n\n".
                    "Ditransfer ke rek:\n\n".
                    "Bank      : ".$data['bank']."\n".
                    "Nama    : ".$data['nama_rek']."\n".
                    "No. Rek : ".$data['no_rek']."\n\n".
                    "==========================\n".
                    "Sisa Saldo Kas Besar : \n".
                    "Rp. ".number_format($store->saldo, 0, ',', '.')."\n\n".
                    "Total Modal Investor : \n".
                    "Rp. ".number_format($store->modal_investor_terakhir, 0, ',', '.')."\n\n".
                    "Terima kasih 🙏🙏🙏\n";
        $send = new StarSender($group->nama_group, $pesan);
        $res = $send->sendGroup();

        return redirect()->route('billing')->with('success', 'Data berhasil disimpan');
    }
}
