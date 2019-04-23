<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PelangganTransaksiController extends Controller
{
    public function index()
    {
        return view('pelanggan.transaksi');
    }
}
