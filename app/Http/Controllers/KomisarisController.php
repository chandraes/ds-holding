<?php

namespace App\Http\Controllers;

use App\Models\Komisaris;
use Illuminate\Http\Request;

class KomisarisController extends Controller
{
    public function index()
    {
        $data = Komisaris::all();
        return view('db.komisaris.index',
        [
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required',
            'no_wa' => 'required',
            'no_rek' => 'required',
            'bank' => 'required',
            'nama_rek' => 'required',
        ]);

        Komisaris::create($data);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, Komisaris $komisaris)
    {

    }

    public function destroy(Komisaris $komisaris)
    {

    }
}
