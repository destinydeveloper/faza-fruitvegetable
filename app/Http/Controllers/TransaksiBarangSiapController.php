<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;

use App\Models\Transaksi;
use App\Models\TransaksiBarang;
use App\Models\TransaksiBayar;
use App\Models\TransaksiKonfirmasi;

class TransaksiBarangSiapController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) return $this->getAll($request);
        return view('user.transaksi.barang_siap');
    }

    public function getAll($request)
    {
        $query = Transaksi::with('bayar', 'barangs', 'barangs.barang')
            ->whereMetode('kirim barang')
            ->doesntHave('track')
            ->doesntHave('batal')
            ->has('dikonfirmasi');
        
        return DataTables::of($query->orderBy('created_at', 'DESC'))
            ->addColumn('no', function($u){
                static $no = 1;
                return $no++;
            })
            ->addColumn('action', function($u){
                $transaksi_id = $u->id;
                $transaksi_kode = $u->kode;
                $delete = $u->dikonfirmasi->id.", '$transaksi_kode'";
                return '
                    <button onclick="app.delete('.$delete.')" class="btn btn-xs btn-danger" title="Batalkan Konfirmasi" data-toggle="tooltip" data-placement="top" title="Tolak Konfirmasi">
                        <i class="fa fa-fw fa-chevron-left"></i>
                    </button>
                    <button onclick="app.kirim('.$delete.')" class="btn btn-xs btn-success" title="Kirim ke Penerima" data-toggle="tooltip" data-placement="top" title="Kirim ke Penerima">
                        <i class="fa fa-fw fa-chevron-right"></i>
                    </button>
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
            
            case 'kirim':
                $request->validate([ 'id' => 'required|integer' ]);
                $check = Transaksi::findOrFail($request->input('id'));
                $result = \App\Models\TransaksiTrack::create([
                    "transaksi_id" => $request->input('id'),
                    "status" => "Proses Pengemasan"
                ]);
                return response()->json([
                    'status' => 'success',
                    'result' => $result
                ]);
                break;

            case 'delete':
                $request->validate([ 'id' => 'required|integer' ]);
                $delete = TransaksiKonfirmasi::find($request->input('id'))->delete();
                return response()->json([
                    'status' => 'success',
                    'result' => $request->input('id')
                ]);
                break;
        }
        return abort(404);
    }
}
