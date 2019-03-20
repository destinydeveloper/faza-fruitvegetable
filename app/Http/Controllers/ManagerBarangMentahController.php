<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;

use App\Models\BarangMentah;
use App\Models\Barang;

class ManagerBarangMentahController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) return $this->getAll();
        return view('user.manager.barang_mentah');
    }

    public function getAll()
    {
        return DataTables::of(BarangMentah::with('user', 'barang'))
            ->addColumn('no', function(){
                static $no = 1;
                return $no++;
            })
            ->addColumn('action', function($u){
                $id = $u->id;
                $nama = "'".$u->barang->nama ."'";
                $username = "'".$u->user->nama ."'";
                return '
                    <button onclick="app.add('.$id.', '.$nama.')" title="Pindahkan Ke Barang" class="btn btn-xs btn-success"><i class="fa fa-chevron-right "></i></button>
                    <button onclick="app.edit('.$id.')" title="Edit" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></button>
                    <button onclick="app.delete('.$id.', '.$nama.', '.$username.')" title="Hapus" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                ';
            })
            ->make(true);
    }

    public function action(Request $request)
    {
        if (!$request->has('action')) return $this->errResponse('action not found');
        
        switch($request->input('action'))
        {
            case 'delete':
                $BarangMentah = BarangMentah::findOrFail($request->input('id'));
                $BarangMentah->delete();

                return response()->json(['status' => 'success', 'result' => $request->input('id')]);
                break;
            
            case 'detail':
                $BarangMentah = BarangMentah::with('user', 'barang')->findOrFail($request->input('id'));
                
                return response()->json(['status' => 'success', 'result' => $BarangMentah]);
                break;
            
            case 'update':
                $request->validate(['stok' => 'required|integer']);
                
                $BarangMentah = BarangMentah::findOrFail($request->input('id'));
                $BarangMentah->update(['stok' => $request->input('stok')]);
               
                return response()->json(['status' => 'success', 'result' => $request->input('id')]);
                break;

            case 'add':
                $request->validate(['id' => 'required|integer']);
                $BarangMentah = BarangMentah::with('barang')->findOrFail($request->input('id'));
                $barang = Barang::findOrFail($BarangMentah->barang->id);
                $barang->increment('stok', $BarangMentah->stok);
                $BarangMentah->delete();
                
                return response()->json(['status' => 'success', 'result' => $barang->id]);
                break;
        }
    }


    /**
     * EROR HANDLE
     */

    private function errResponse($msg)
    {
        $errCode = 200;
        return response()->json(['status'=>'error', 'error' => $msg], $errCode);
    }
}
