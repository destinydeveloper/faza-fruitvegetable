<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Barang;

class PelangganKeranjangController extends Controller
{
    public function index()
    {
        // keranjang()->add(1, 25);
        $keranjang = keranjang()->get();
        // return $keranjang;
        return view('pelanggan.keranjang', compact('keranjang'));
    }

    public function action(Request $request)
    {
        if (!$request->has('action')) return abort(404);

        switch($request->input('action'))
        {
            case 'beli':
                $request->validate([ 'id' => 'required|integer', 'stok' => 'required|integer' ]);
                $check = Barang::findOrFail($request->input('id'));
                // return $request->all();
                $tes = keranjang()->add($request->input('id'), $request->input('stok'));
                // dd($tes);
                return redirect()->route('keranjang');
                break;
        }

        return abort(404);
    }
}
