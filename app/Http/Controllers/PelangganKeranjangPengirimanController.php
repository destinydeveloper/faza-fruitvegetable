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
        }
        return abort(404);
    }
}
