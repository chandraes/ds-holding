<?php

namespace App\Http\Controllers;

use App\Models\KasBesar;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index()
    {
        return view('billing.index');
    }

    public function saldo_temp()
    {
        $db = new KasBesar();
        $db->insertSaldoTemp();

        return redirect()->route('billing')->with('success', 'Saldo berhasil diupdate');
    }
}
