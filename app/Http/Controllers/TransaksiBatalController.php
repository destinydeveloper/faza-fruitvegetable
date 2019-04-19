<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;

use App\Models\Transaksi;

class TransaksiBatalController extends Controller
{
    public function index(Request $request)
    {
        // return $this->getAll($request);
        if ($request->ajax()) return $this->getAll($request);
        return view("user.transaksi.barang_batal");
    }

    public function getAll($request)
    {
        $query = Transaksi::with('bayar', 'barangs', 'barangs.barang', 'batal')
            ->has('batal');
        
        return DataTables::of($query->orderBy('created_at', 'DESC'))
            ->addColumn('no', function($u){
                static $no = 1;
                return $no++;
            })
            ->addColumn('action', function($u){
                $transaksi_id = $u->id;
                return '
                    <button onclick="app.detail('.$transaksi_id.')" class="btn btn-xs btn-info" title="Detail Transaksi"  data-toggle="tooltip" data-placement="top" title="Detail Transaksi">
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
                    'result' => Transaksi::with('barangs', 'barangs.barang', 'bayar', 'user', 'alamat')
                                ->findOrFail($request->input('id'))
                ]);
                break;
            }
            return abort(404);
        }
}
