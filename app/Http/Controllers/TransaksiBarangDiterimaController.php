<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;

use App\Models\Transaksi;

class TransaksiBarangDiterimaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) return $this->getAll($request);
        return view('user.transaksi.barang_diterima');
    }

    public function getAll($request)
    {
        $query = Transaksi::with('bayar', 'barangs', 'barangs.barang', 'berhasil')
            ->has('berhasil');
        
        return DataTables::of($query->orderBy('created_at', 'DESC'))
            ->addColumn('no', function($u){
                static $no = 1;
                return $no++;
            })
            ->addColumn('diterima', function($u){
                return $u->berhasil->created_at;
            })
            ->addColumn('pengantar', function($u){
                return $u->berhasil->pengantar;
            })
            ->addColumn('penerima', function($u){
                return $u->berhasil->penerima;
            })
            ->addColumn('action', function($u){
                $transaksi_id = $u->id;
                $transaksi_kode = $u->kode;
                return '
                    <button onclick="app.detail('.$transaksi_id.')" class="btn btn-xs btn-info" title="Detail Transaksi" data-toggle="tooltip" data-placement="top" data-toggle="tooltip" data-placement="top" title="Detail Transaksi" title="Detail Transaksi">
                        <i class="fa fa-fw fa-info"></i>
                    </button>
                ';
            })
            ->make(true);
    }



    public function action(Request $request)
    {

        if (!$request->has('action')) return abort(404);

        switch($request->input('action'))
        {
            case 'detail':
                $request->validate([ 'id' => 'required|integer' ]);
                return response()->json([
                    'status' => 'success',
                    'result' => Transaksi::with('barangs', 'barangs.barang', 'bayar', 'user', 'alamat', 'track')
                                ->findOrFail($request->input('id'))
                ]);
                break;
        }

        return abort(404);
    }
}
