<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use Illuminate\Http\Request;

class DivisiController extends Controller
{
    public function index()
    {
        $data = Divisi::all();
        return view('db.divisi.index', [
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required',
            'url' => 'required',
        ]);

        Divisi::create($data);

        return redirect()->back()->with('success', 'Berhasil menambahkan data');
    }

    public function update(Request $request, Divisi $divisi)
    {
        $data = $request->validate([
            'nama' => 'required',
            'url' => 'required',
        ]);

        $divisi->update($data);

        return redirect()->back()->with('success', 'Berhasil mengubah data');
    }

    public function destroy(Divisi $divisi)
    {
        $divisi->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus data');
    }
}
