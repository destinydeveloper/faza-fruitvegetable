<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;

use App\Models\Transaksi;
use App\Models\TransaksiBarang;
use App\Models\TransaksiBayar;


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
        $query = null;
        // $filter = 'sudah';
        switch($filter)
        {
            case 'semua':
                $query = Transaksi::query();
                break;
            case 'belum':
                $query = Transaksi::with('bayar', 'barangs', 'barangs.barang')
                    ->where('metode', 'kirim barang')
                    ->doesntHave('bayar');
                break;

            case 'sudah':
                $query = Transaksi::with('bayar', 'barangs', 'barangs.barang')
                    ->where('metode', 'kirim barang')
                    ->has('bayar');
                break;

            case 'cod':
                $query = Transaksi::with('bayar', 'barangs', 'barangs.barang')
                    ->where('metode', 'cod');
                break;
        }


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
                <button onclick="app.konfirmasi('.$transaksi_id.')" title="Konfirmasi" class="btn btn-xs btn-success"><i class="fa fa-chevron-right"></i></button>
                <button onclick="app.delete('.$delete.')" title="Tolak" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></button>
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
                $delete = Transaksi::find($request->input('id'))->delete();
                return response()->json([
                    'status' => 'success',
                    'result' => $request->input('id')
                ]);
                break;
            
            case 'konfirmasi':
                $request->validate([ 'id' => 'required|integer', 'metode' => 'required|string' ]);
                if ($request->metode == 'kirim barang') {
                    return "a";
                } elseif ($request->metode == 'cod') {
                    return "b";
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
