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
        $data = new PersenDivisi;
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
            // create or update persen divisi where divisi_id and komisaris_id
            PersenDivisi::updateOrCreate(
                [
                    'divisi_id' => $data['divisi_id'],
                    'komisaris_id' => $data['komisaris_id'],
                ],
                [
                    'persen' => $data['persen'],
                ]
            );
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Komisaris sudah terdaftar di divisi ini');
        }


        DB::commit();

        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }


}
