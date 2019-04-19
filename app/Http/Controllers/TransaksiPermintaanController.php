<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;

use App\Models\Transaksi;
use App\Models\TransaksiBarang;
use App\Models\TransaksiBayar;
use App\Models\TransaksiKonfirmasi;
use App\Models\TransaksiBatal;


class TransaksiPermintaanController extends Controller
{
    public function index(Request $request) 
    {
        // return $this->getAll($request);
        if ($request->ajax()) return $this->getAll($request);
        return view('user.transaksi.permintaan');
    }

    public function getAll($request)
    {
        if (!$request->has('filter')) return $this->errResponse("Filter not found");
        $filter = $request->input('filter');
        $query = Transaksi::with('bayar', 'barangs', 'barangs.barang')
            ->doesntHave('batal')
            ->doesntHave('dikonfirmasi');
        // $filter = 'sudah';
        switch($filter)
        {
            case 'semua':
                break;
            case 'belum':
                $query = $query
                    ->where('metode', 'kirim barang')
                    ->doesntHave('bayar');
                break;

            case 'sudah':
                $query = $query->where('metode', 'kirim barang')
                    ->has('bayar');
                break;

            case 'cod':
                $query = $query->where('metode', 'cod');
                break;
        }


        return DataTables::of($query->orderBy('created_at', 'DESC'))
        ->addColumn('no', function($u){
            static $no = 1;
            return $no++;
        })
        ->addColumn('status', function($u){
            return $u->bayar != null ? "Sudah Dibayar" : ($u->metode == 'kirim barang' ? "Belum Dibayar" : '-');
        })
        ->addColumn('action', function($u){
            $transaksi_id = $u->id;
            $transaksi_kode = $u->kode;
            $delete = "$transaksi_id, '$transaksi_kode'";
            return '
                <button onclick="app.konfirmasi('.$transaksi_id.')" data-toggle="tooltip" data-placement="top" title="Konfirmasi" title="Konfirmasi" class="btn btn-xs btn-success"><i class="fa fa-chevron-right"></i></button>
                <button onclick="app.delete('.$delete.')" data-toggle="tooltip" data-placement="top" title="Tolak" title="Tolak" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></button>
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

            case 'delete':
                $request->validate([ 'id' => 'required|integer' ]);
                $transaksi = Transaksi::find($request->input('id'));
                $delete = TransaksiBatal::create([
                    'transaksi_id' => $request->input('id'),
                    'catatan' => "transaksi tidak disetujui"
                ]);
                return response()->json([
                    'status' => 'success',
                    'result' => $request->input('id')
                ]);
                break;
            
            case 'konfirmasi':
                $request->validate([ 'id' => 'required|integer', 'metode' => 'required|string' ]);
                $id = $request->id;
                if ($request->metode == 'kirim barang') {
                    $konfirmasi = TransaksiKonfirmasi::create([ 'transaksi_id' => $id ]);
                    $bayar = TransaksiBayar::create([
                        'transaksi_id' => $id,
                        'nominal' => $request->nominal,
                        'catatan' => $request->catatan,
                    ]);
                    return response()->json([
                        'status' => 'success',
                        'result' => $id
                    ]);
                } elseif ($request->metode == 'cod') {
                    $konfirmasi = TransaksiKonfirmasi::create([ 'transaksi_id' => $id ]);
                    return response()->json([
                        'status' => 'success',
                        'result' => $id
                    ]);
                } else {
                    return abort(404);
                }
                break;
        }

        return abort(404);
    }



    /**
     * EROR HANDLE
     */
    private function errResponse($msg, $errCode = 200)
    {
        return response()->json(['status'=>'error', 'error' => $msg], $errCode);
    }
}
