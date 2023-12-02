<?php

namespace App\Http\Controllers;

use App\Models\KasGajiKomisaris;
use App\Models\Divisi;
use App\Models\PersenKas;
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

        $db->insertDividen($data);

        DB::commit();

        return redirect()->route('billing')->with('success', 'Berhasil menambahkan data');

    }
}
