<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PelangganKeranjangPengirimanController extends Controller
{
    public function index(Request $request)
    {
        if (!$this->validationKeranjang()) return redirect()->route('keranjang');

        $keranjang = keranjang()->get();
        $alamat = Auth()->user()->alamat;
        $ekspedisi = Ekspedisi()->get();

        session(['last_shipment' => url()->current()]);
        return view('pelanggan.keranjang_pengiriman', compact('keranjang', 'alamat', 'ekspedisi'));
    }

    public function validationKeranjang()
    {
        if (keranjang()->count() == 0) return false;

        $keranjang = keranjang()->get();
        foreach($keranjang as $item)
        {
            if ($item->error != "") return false;
        }

        return true;
    }

    public function action(Request $request)
    {
        if (!$request->has('action')) return abort(404);

        switch($request->input('action'))
        {
            case 'cekongkir':
                $request->validate([ 'ekspedisi' => 'required', 'berat' => 'required|integer', 'alamat' => 'required' ]);
                $ekspedisi = (array) json_decode(json_encode(Ekspedisi()->get()));

                if (!isset($ekspedisi[$request->input('ekspedisi')])) return response()->json([
                    'status' => 'error',
                    'error' => "Ekspedisi tidak ada"
                ], 200);

                $tujuan = explode(", ", $request->input('alamat'))[1];
                $berat = $request->input('berat');
                $ekspedisi = $request->input('ekspedisi');
                $ongkir = Ekspedisi()->name($ekspedisi)->calculate('KOTA MALANG', $tujuan, $berat);
                
                return response()->json([
                    'status' => 'success',
                    'result' => $ongkir
                ], 200);
                break;
            
            case 'transaksi':
                $request->validate([ 
                    'metode' => 'required', 
                    'layanan' => 'required|integer', 
                    'alamat' => 'required' 
                ]);
                

                # VALIDASI COD / KIRIM BARANG
                if ($request->input('metode') == 'cod') 
                {
                    $transaksi = keranjang()->toTransaksi("cod", $request->input('alamat'));
                    if ( $transaksi === true) return "berhasil";
                    return $transaksi;
                    
                } else {
                    # CEK ADAKAH EKSPEDISI / VALIDASI
                    $ekspedisi = (array) json_decode(json_encode(Ekspedisi()->get()));
                    if (!isset($ekspedisi[$request->input('metode')])) return response()->json([
                        'status' => 'error',
                        'error' => "Ekspedisi tidak ada"
                    ], 200);

                    # CEK ONGKIR SEKALI LAGI
                    $alamat = \App\Models\Alamat::findOrFail($request->input('alamat'));
                    $tujuan = explode(", ", $alamat->alamat)[1];
                    $berat = keranjang()->getTotalBerat();
                    $ekspedisi = $request->input('metode');
                    $ongkir = Ekspedisi()->name($ekspedisi)->calculate('KOTA MALANG', $tujuan, $berat);

                    if(!isset($ongkir['ongkir']['costs'][$request->input('layanan')])) return response()->json([
                        'status' => 'error',
                        'error' => "Layanan tidak ada"
                    ], 200);

                    $layanan_ongkir = $ongkir['ongkir']['costs'][$request->input('layanan')];
                    $harga_ongkir = $layanan_ongkir['cost'][0]['value'];                

                    $ekspedisi_detail = [
                        'nama' => $ekspedisi,
                        'layanan' => $layanan_ongkir['service'] . ' ['.$layanan_ongkir['description'].')' ,
                        'ongkir' => $harga_ongkir,
                        'tujuan' => $alamat->alamat,
                    ];

                    $transaksi = keranjang()->toTransaksi("kirim barang", $request->input('alamat'), $ekspedisi_detail);
                    if ( $transaksi === true) return "berhasil";
                    return $transaksi;
                }

                dd($request->all());
                break;
        }
        return abort(404);
    }
}
