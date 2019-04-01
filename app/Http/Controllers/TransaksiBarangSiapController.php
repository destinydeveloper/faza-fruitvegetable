<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransaksiBarangSiapController extends Controller
{
    public function index()
    {
        return view('user.transaksi.barang_siap');
    }
}
