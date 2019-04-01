<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransaksiBarangDiterimaController extends Controller
{
    public function index()
    {
        return view('user.transaksi.barang_diterima');
    }
}
