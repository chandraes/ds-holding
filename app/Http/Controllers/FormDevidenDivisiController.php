<?php

namespace App\Http\Controllers;

use App\Models\KasGajiKomisaris;
use App\Models\Divisi;
use App\Models\PersenKas;
use Illuminate\Http\Request;

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
            'nominal' => 'required',
        ]);

        $divisi = Divisi::findOrFail($data['divisi_id']);

        $db = new KasGajiKomisaris();

        
    }
}
