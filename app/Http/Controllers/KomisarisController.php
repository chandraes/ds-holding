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
            'persen_saham' => 'required',
        ]);

        $check = Komisaris::sum('persen_saham') + $data['persen_saham'];

        if ($check > 100) {
            return redirect()->back()->with('error', 'Persentase saham tidak boleh lebih dari 100%');
        }

        Komisaris::create($data);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, Komisaris $komisaris)
    {
        $data = $request->validate([
            'nama' => 'required',
            'no_wa' => 'required',
            'no_rek' => 'required',
            'bank' => 'required',
            'nama_rek' => 'required',
            'persen_saham' => 'required',
        ]);

        $check = Komisaris::sum('persen_saham') - $komisaris->persen_saham + $data['persen_saham'];

        if ($check > 100) {
            return redirect()->back()->with('error', 'Persentase saham tidak boleh lebih dari 100%');
        }

        $komisaris->update($data);

        return redirect()->back()->with('success', 'Data berhasil diubah');
    }

    public function destroy(Komisaris $komisaris)
    {
        $komisaris->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
