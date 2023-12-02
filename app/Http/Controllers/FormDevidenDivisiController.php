<?php

namespace App\Http\Controllers;

use App\Models\KasGajiKomisaris;
use App\Models\Divisi;
use App\Models\PersenKas;
use App\Services\StarSender;
use App\Models\GroupWa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormDevidenDivisiController extends Controller
{
    public function index()
    {
        $data = Divisi::all();

        return view('billing.deviden-divisi.index', [
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'divisi_id' => 'required|exists:divisis,id',
            'nominal_transaksi' => 'required',
        ]);

        $db = new KasGajiKomisaris();

        DB::beginTransaction();

        $store = $db->insertDividen($data);

        $group = GroupWa::where('untuk', 'kas-besar')->first();
        $pesan =    "🔵🔵🔵🔵🔵🔵🔵🔵🔵\n".
                    "*Form Dividen Divisi*\n".
                    "🔵🔵🔵🔵🔵🔵🔵🔵🔵\n\n".
                    $store->uraian."\n\n".
                    "Nilai :  *Rp. ".number_format($store->nominal_transaksi, 0, ',', '.')."*\n\n".
                    "Ditransfer ke rek:\n\n".
                    "Bank      : ".$store->bank."\n".
                    "Nama    : ".$store->nama_rek."\n".
                    "No. Rek : ".$store->no_rek."\n\n".
                    "==========================\n".
                    "Sisa Saldo Kas Besar : \n".
                    "Rp. ".number_format($store->saldo, 0, ',', '.')."\n\n".
                    "Total Modal Investor : \n".
                    "Rp. ".number_format($store->modal_investor_terakhir, 0, ',', '.')."\n\n".
                    "Terima kasih 🙏🙏🙏\n";
        $send = new StarSender($group->nama_group, $pesan);
        $res = $send->sendGroup();

        DB::commit();

        return redirect()->route('billing')->with('success', 'Berhasil menambahkan data');

    }
}
