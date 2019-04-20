<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Barang;

class PelangganKeranjangController extends Controller
{
    public function index(Request $request)
    {
        // return $this->getKeranjang();
        if ($request->ajax()) return $this->getKeranjang();
        return view('pelanggan.keranjang');
    }

    public function getKeranjang()
    {
        $keranjang = keranjang()->get();

        return response()->json([
            'status' => 'success',
            'result' => $keranjang
        ], 200);
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
            
            case 'tambah':
                $request->validate([ 'id' => 'required|integer', 'stok' => 'required|integer' ]);
                $check = Barang::findOrFail($request->input('id'));
                $keranjang = keranjang()->add($request->input('id'), $request->input('stok'));
                return response()->json([
                    'status' => 'success',
                    'result' => $keranjang
                ], 200);
                break;
            
                case 'delete':
                    $request->validate([ 'id' => 'required|integer']);
                    $keranjang = keranjang()->remove($request->input('id'));
                    return response()->json([
                        'status' => 'success',
                        'result' => $keranjang
                    ], 200);
                    break;
            
                case 'destroy':
                    $keranjang = keranjang()->destroy();
                    return response()->json([
                        'status' => 'success',
                        'result' => $keranjang
                    ], 200);
                    break;
            
            case 'updateStok':
                $request->validate([ 'id' => 'required|integer', 'stok' => 'required|integer' ]);
                $update = keranjang()->update($request->input('id'), $request->input('stok'));
                return response()->json([
                    'status' => 'success',
                    'result' => $update
                ], 200);
                break;
                
        }

        return abort(404);
    }
}
