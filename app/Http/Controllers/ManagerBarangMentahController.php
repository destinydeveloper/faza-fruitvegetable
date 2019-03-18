<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;

use App\Models\BarangMentah;

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
                return '
                    <button onclick="app.add('.$id.')" title="Pindahkan Ke Barang" class="btn btn-xs btn-success"><i class="fa fa-chevron-right "></i></button>
                    <button onclick="app.edit('.$id.')" title="Edit" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></button>
                    <button onclick="app.delete('.$id.')" title="Hapus" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                ';
            })
            ->make(true);
    }


}
