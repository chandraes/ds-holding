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

    }

    public function update(Request $request, Komisaris $komisaris)
    {

    }

    public function destroy(Komisaris $komisaris)
    {

    }
}
