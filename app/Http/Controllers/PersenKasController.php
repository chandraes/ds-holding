<?php

namespace App\Http\Controllers;

use App\Models\PersenKas;
use Illuminate\Http\Request;

class PersenKasController extends Controller
{
    public function index()
    {
        $data = PersenKas::all();
        return view('db.persen-kas.index',
        [
            'data' => $data
        ]);
    }

    public function update(Request $request, PersenKas $persenKas)
    {
        $data = $request->validate([
            'nama' => 'required',
            'persen' => 'required',
        ]);

        $check = PersenKas::sum('persen');

        if ($check - $persenKas->persen + $data['persen'] > 100) {
            return redirect()->back()->with('error', 'Persen kas melebihi 100%');
        }

        $persenKas->update($data);

        return redirect()->back()->with('success', 'Data berhasil diubah');
    }
}
