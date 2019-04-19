<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Helpers\Images;

use App\Models\Barang;
use App\Models\GambarBarang;

class ManagerBarangController extends Controller
{
    public function index(Request $request)
    {
        // $barang = new Barang();
        // $barang->nama = 'KOL';
        // $barang->berat = '84000';
        // $barang->harga = '78000';
        // $barang->save();


        if ($request->ajax()) {
            $barang = Barang::query();

            if ($request->has('filter') and $request->input('filter') == 'sayur') $barang = Barang::whereJenis('sayur');
            if ($request->has('filter') and $request->input('filter') == 'buah') $barang = Barang::whereJenis('buah');


            return DataTables::of($barang)
            ->addColumn('no', function(){
                static $no = 1;
                return $no++;
            })
            ->addColumn('jenis', function($u){
                return ucfirst($u->jenis);
            })
            ->addColumn('status', function($u){
                return $u->status == 1 ? 'Ditampilkan' : 'Disembunyikan';
            })
            ->addColumn('stok', function($u){
                return $u->stok == 0 ? 'Habis' : $u->stok;
            })
            ->addColumn('harga', function($u){
                return "Rp " . number_format($u->harga,2,',','.');
            })
            ->addColumn('action', function($u){
                $id = $u->id;
                $nama = "'".$u->nama."'";
                return '
                    <button onclick="app.detail('.$id.')" title="Lihat" class="btn btn-xs btn-success"><i class="fa fa-search"></i></button>
                    <button onclick="app.edit('.$id.')" title="Edit" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></button>
                    <button onclick="app.delete('.$id.', '.$nama.')" title="Hapus" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                ';
            })
            ->make(true);
        }

        return view('user.manager.barang');
    }


    public function action(Request $request)
    {
        switch($request->input('action'))
        {
            case 'update':
                // return $request->all();

                $request->validate([
                    'nama' => 'required',
                    'id' => 'required|integer',
                    'jenis' => 'required|in:sayur,buah',
                    'harga' => 'required|integer',
                    'berat' => 'required|integer',
                    'stok' => 'required|integer',
                    'satuan_berat' => 'required',
                    'satuan_stok' => 'required',
                    'status' => 'required|in:0,1',
                ]);

                $barang = Barang::with('gambar')->findOrFail($request->input('id'));
                // if ($request->has('images_old')) return $request->file('images_old')
                if ($request->has('images_old') and count($request->input('images_old')) > 0) {
                    $images_old = $request->input('images_old');
                    $images_db = $barang->gambar;
                    $images_db_id = [];

                    foreach ($images_db as $img){
                        $images_db_id[] = $img->id;
                    }
                    
                    foreach($images_db_id as $img_k => $img)
                    {
                        if (in_array($img, $images_old)) unset($images_db_id[$img_k]);
                    }
                    
                    $GambarBarang = GambarBarang::destroy($images_db_id);
                } else {
                    GambarBarang::whereBarangId($request->input('id'))->delete();
                }

                $gambar = [];

                $barang = Barang::findOrFail($request->input('id'))->update([
                    'nama' => $request->input('nama'),
                    'jenis' => $request->input('jenis'),
                    'harga' => $request->input('harga'),
                    'berat' => $request->input('berat'),
                    'stok' => $request->input('stok'),
                    'satuan_berat' => $request->input('satuan_berat'),
                    'satuan_stok' => $request->input('satuan_stok'),
                    'status' => $request->input('status'),
                ]);
                
                if ($request->has('images')) {
                    $gambar = Images::multipleUpload('images');
                    $createGambar = [];
                    if (count((array) $gambar) > 0) {

                        foreach($gambar as $data)
                        {
                            $GambarBarang = GambarBarang::create([
                                'gambar_id' => $data->id,
                                'barang_id' => $request->input('id')
                            ]);
                        }
                    }
                }

                return response()->json(['status' => 'success', 'result' => $request->input('id')]);

                break;

            case 'detail':
                $request->validate([ 'id' => 'required|integer' ]);
                $barang = Barang::with('gambar')->findOrFail($request->input('id'));
                return response()->json(['status' => 'success', 'result' => $barang]);
                break;

            case 'delete':
                $request->validate([ 'id' => 'required|integer' ]);
                $barang = Barang::with('gambar')->findOrFail($request->input('id'));
                $delete = $barang->gambar()->delete();
                $delete = $barang->delete();

                return response()->json(['status' => 'success', 'result' => $delete]);
                break;

            case 'addnew':
                $request->validate([
                    'nama' => 'required',
                    'jenis' => 'required|in:sayur,buah',
                    'harga' => 'required|integer',
                    'berat' => 'required|integer',
                    'stok' => 'required|integer',
                    'satuan_berat' => 'required',
                    'satuan_stok' => 'required',
                ]);

                $gambar = [];

                $barang = Barang::create([
                    'nama' => $request->input('nama'),
                    'jenis' => $request->input('jenis'),
                    'harga' => $request->input('harga'),
                    'berat' => $request->input('berat'),
                    'stok' => $request->input('stok'),
                    'satuan_berat' => $request->input('satuan_berat'),
                    'satuan_stok' => $request->input('satuan_stok'),
                ]);
                
                if ($request->has('images')) {
                    $gambar = Images::multipleUpload('images');
                    $createGambar = [];
                    if (count((array) $gambar) > 0) {

                        foreach($gambar as $data)
                        {
                            $GambarBarang = GambarBarang::create([
                                'gambar_id' => $data->id,
                                'barang_id' => $barang->id
                            ]);
                        }
                    }
                }

                return response()->json(['status' => 'success', 'result' => $barang->id]);
                break;
            
            default:
                break;
        }

        return abort(404);
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
