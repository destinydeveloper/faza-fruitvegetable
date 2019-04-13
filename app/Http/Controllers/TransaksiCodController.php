<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;

use App\Models\Transaksi;
use App\Models\TransaksiBarang;
use App\Models\TransaksiBayar;

class TransaksiCodController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) return $this->getAll($request);
        return view('user.transaksi.cod');
    }

    public function getAll($request)
    {
        $filter = $request->input('filter');
        $query = Transaksi::with('bayar', 'barangs', 'barangs.barang')
            ->whereMetode('cod')
            ->has('konfirmasi');
        
        return DataTables::of($query->orderBy('created_at', 'DESC'))
            ->addColumn('no', function($u){
                static $no = 1;
                return $no++;
            })
            ->addColumn('action', function($u){
                $transaksi_id = $u->id;
                $transaksi_kode = $u->kode;
                $delete = "$transaksi_id, '$transaksi_kode'";
                return '
                    <button onclick="app.detail('.$transaksi_id.')" data-toggle="tooltip" data-placement="top" title="Detail Transaksi" title="Detail" class="btn btn-xs btn-primary"><i class="fa fa-fw fa-info"></i></button>
                    <button onclick="app.selesai('.$transaksi_id.')" title="Selesaikan" data-toggle="tooltip" data-placement="top" title="Selesaikan Transaksi" class="btn btn-xs btn-success"><i class="fa fa-check"></i></button>
                    <button onclick="app.delete('.$delete.')" title="Batalkan" data-toggle="tooltip" data-placement="top" title="Batalkan Transaksi" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                ';
            })
            ->make(true);
    }
}
