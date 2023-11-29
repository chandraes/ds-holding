<?php

namespace App\Http\Controllers;

use App\Models\PersenDivisi;
use App\Models\Komisaris;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersenDivisiController extends Controller
{
    public function index()
    {
        $data = PersenDivisi::all();
        $komisaris = Komisaris::all();
        $divisi = Divisi::all();
        return view('db.persen-divisi.index',
        [
            'data' => $data,
            'komisaris' => $komisaris,
            'divisi' => $divisi,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'divisi_id' => 'required',
            'komisaris_id' => 'required',
            'persen' => 'required',
        ]);

        $check = PersenDivisi::where('divisi_id', $data['divisi_id'])->sum('persen');

        if ($check + $data['persen'] > 100) {
            return redirect()->back()->with('error', 'Persen divisi melebihi 100%');
        }

        DB::beginTransaction();

        try {
            PersenDivisi::create($data);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Komisaris sudah terdaftar di divisi ini');
        }


        DB::commit();

        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, PersenDivisi $persenDivisi)
    {
        $data = $request->validate([
            'divisi_id' => 'required',
            'komisaris_id' => 'required',
            'persen' => 'required',
        ]);

        $check = PersenDivisi::where('divisi_id', $data['divisi_id'])->sum('persen');

        if ($check - $persenDivisi->persen + $data['persen'] > 100) {
            return redirect()->back()->with('error', 'Persen divisi melebihi 100%');
        }

        DB::beginTransaction();

        try {
            $persenDivisi->update($data);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Komisaris sudah terdaftar di divisi ini');
        }

        DB::commit();

        return redirect()->back()->with('success', 'Data berhasil diubah');
    }

    public function destroy(PersenDivisi $persenDivisi)
    {
        $persenDivisi->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

}
