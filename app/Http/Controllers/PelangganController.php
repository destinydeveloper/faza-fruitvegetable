<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Barang;

class PelangganController extends Controller
{
    public function index()
    {
        $barangs = Barang::with('gambar')->whereStatus("1")->get();
        return view('pelanggan.home', compact('barangs'));
    }

    public function search($q)
    {
        $barangs = Barang::with('gambar')
            ->whereStatus("1")->where("nama", "LIKE", "%{$q}%")
            ->get();
        return view('pelanggan.cari', compact("barangs", "q"));;
    }

    public function buah()
    {
        $barangs = Barang::with('gambar')
            ->whereStatus("1")->whereJenis('buah')
            ->get();
        return view('pelanggan.home', compact('barangs'));
    }

    public function sayur()
    {
        $barangs = Barang::with('gambar')
            ->whereStatus("1")->whereJenis('sayur')
            ->get();
        return view('pelanggan.home', compact('barangs'));
    }

    public function barang_detail($id)
    {
        $barang = Barang::with('gambar')->find($id);
        return view('pelanggan.barang_detail', compact('barang'));
    }
}
