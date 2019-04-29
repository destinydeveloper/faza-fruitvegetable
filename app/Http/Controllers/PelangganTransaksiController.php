<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Transaksi;

class PelangganTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $proseskirim = Transaksi::with('user', 'alamat', 'barangs', 'barangs.barang', 'barangs.barang.gambar', 'bayar', 'track', 'ekspedisi', 'batal', 'berhasil', 'dikonfirmasi')
            ->whereUserId(Auth()->user()->id)->whereMetode('kirim barang')
            ->doesntHave('batal')->doesntHave('berhasil')->has('dikonfirmasi')
            ->get();
        $sampai = Transaksi::with('user', 'alamat', 'barangs', 'barangs.barang', 'barangs.barang.gambar', 'bayar', 'track', 'ekspedisi', 'batal', 'berhasil', 'dikonfirmasi')
            ->whereUserId(Auth()->user()->id)
            ->doesntHave('batal')->has('berhasil')->get();
        $batal = Transaksi::with('user', 'alamat', 'barangs', 'barangs.barang', 'barangs.barang.gambar', 'bayar', 'track', 'ekspedisi', 'batal', 'berhasil', 'dikonfirmasi')
            ->whereUserId(Auth()->user()->id)
            ->has('batal')->get();
        $belumkonfirmasi = Transaksi::with('user', 'alamat', 'barangs', 'barangs.barang', 'barangs.barang.gambar', 'bayar', 'track', 'ekspedisi', 'batal', 'berhasil', 'dikonfirmasi')
            ->whereUserId(Auth()->user()->id)->whereMetode('kirim barang')
            ->doesntHave('batal')->doesntHave('dikonfirmasi')->get();
        $cod = Transaksi::with('user', 'alamat', 'barangs', 'barangs.barang', 'barangs.barang.gambar', 'bayar', 'track', 'ekspedisi', 'batal', 'berhasil', 'dikonfirmasi')
            ->whereUserId(Auth()->user()->id)
            ->doesntHave('batal')->whereMetode('cod')
            ->get();

        return view('pelanggan.transaksi', compact('proseskirim', 'sampai', 'batal', 'belumkonfirmasi', 'cod'));
    }
}
