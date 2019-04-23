<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;

use App\Models\Transaksi;
use App\Models\TransaksiTrack;
use App\Models\TransaksiBerhasil;

class TransaksiTraceTrackController extends Controller
{
    public function index(Request $request)
    {
        // return $this->getAll($request);
        if ($request->ajax()) return $this->getAll($request);
        return view('user.transaksi.trace_track');
    }

    public function getAll($request)
    {
        $query = Transaksi::with('bayar', 'barangs', 'barangs.barang')
            ->has('track')
            ->doesntHave('batal')
            ->doesntHave('berhasil');
        
        return DataTables::of($query->orderBy('created_at', 'DESC'))
            ->addColumn('no', function($u){
                static $no = 1;
                return $no++;
            })
            ->addColumn('status', function($u){
                return $u->track[count($u->track)-1]->status;
            })
            ->addColumn('action', function($u){
                $transaksi_id = $u->id;
                $transaksi_kode = $u->kode;
                return '
                    <button onclick="app.selesai('.$transaksi_id.')" data-toggle="tooltip" data-placement="top" title="Konfirmasi Barang Sudah Diterima" class="btn btn-xs btn-success" title="Konfirmasi Barang Sudah Diterima" data-toggle="tooltip" data-placement="top" title="Konfirmasi Barang Sudah Diterima">
                        <i class="fa fa-fw fa-check"></i>
                    </button>
                    <button onclick="app.edit('.$transaksi_id.')" data-toggle="tooltip" data-placement="top" title="Edit Statis" class="btn btn-xs btn-warning" title="Edit Status" data-toggle="tooltip" data-placement="top" title="Edit Status">
                        <i class="fa fa-fw fa-edit"></i>
                    </button>
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
                    'result' => Transaksi::with('barangs', 'barangs.barang', 'bayar', 'user', 'alamat', 'ekspedisi', 'track')
                                ->findOrFail($request->input('id'))
                ]);
                break;
            
            case 'update':
                $request->validate([ 'id' => 'required|integer' ]);
                if (!$request->has('tracks')) {
                    TransaksiTrack::whereTransaksiId($request->input('id'))->delete();
                } else {

                    $track_diupdate = [];
                    $track_old = $request->input('tracks_old');

                    foreach ($request->input('tracks') as $track) {
                        if (!isset($track['id'])) {
                            $this->buatBaru($request->input('id'), $track);
                        } else {
                            $track_diupdate[] = $track['id'];
                            $status = TransaksiTrack::findOrFail($track['id']);
                            $status->update([
                                'status' => $track['status']
                            ]);
                        }


                        $track = (object) $track;
                    }

                    $track_dihapus = [];
                    foreach($track_old as $track)
                    {
                        if (in_array($track['id'], $track_diupdate) ) $track_dihapus[] =  $track['id'];
                    }

                    $hapus = TransaksiTrack::whereNotIn('id', $track_dihapus)->delete();
                }
                
                return response()->json([
                    'status' => 'success',
                    'result' => $hapus
                ]);
                break;
            
            case 'selesai':
                $create = TransaksiBerhasil::create([
                    'transaksi_id' => $request->input('id'),
                    'pengantar' => $request->input('pengantar'),
                    'penerima' => $request->input('penerima'),
                ]);
                
                return response()->json([
                    'status' => 'success',
                    'result' => $create
                ]);  
                break;
        }

        return abort(404);
    }


    public function buatBaru($id, $track)
    {
        TransaksiTrack::create([
            'transaksi_id' => $id,
            'status' => $track['status']
        ]);
    }
}
