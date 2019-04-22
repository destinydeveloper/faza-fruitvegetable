<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;

use App\Models\BiayaOperasional;

class BiayaOperasionalController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) return $this->getAll();
        return view('user.biaya_operasional');
    }

    public function getAll()
    {
        return DataTables::of(BiayaOperasional::query())
                ->addColumn('no', function(){
                    static $no = 1;
                    return $no++;
                })
                ->addColumn('biaya', function($u){
                    return "Rp " . number_format($u->biaya,2,',','.');
                })
                ->addColumn('action', function($u){
                    $id = $u->id;
                    $nama = "'$u->nama'";
                    return '
                        <button onclick="app.edit('.$u->id.')" title="Edit" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></button>
                        <button onclick="app.delete('.$id.', '.$nama.')" title="Hapus" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
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
                $request->validate([ 'id' => 'required|integer']);
                $result = BiayaOperasional::findOrFail($request->input('id'));
                return response()->json(['status' => 'success', 'result' => $result]);
                break;
            
            case 'delete':
                $request->validate([ 'id' => 'required|integer']);
                $result = BiayaOperasional::findOrFail($request->input('id'))->delete();
                return response()->json(['status' => 'success', 'result' => $result]);
                break;
            
            case 'update':
                $request->validate([
                    'id' => 'required|integer',
                    'nama' => 'required',
                    'biaya' =>   'required|integer',
                ]);
                $result = BiayaOperasional::findOrFail($request->input('id'));
                $result = $result->update([
                    "nama" => $request->input('nama'),
                    "biaya" => $request->input('biaya'),
                ]);
                return response()->json(['status' => 'success', 'result' => $result]);
                break;

            case 'addnew':
                $request->validate([
                    'nama' => 'required',
                    'biaya' =>   'required|integer'
                ]);

                $buat = BiayaOperasional::create([
                    "nama" => $request->input('nama'),
                    "biaya" => $request->input('biaya'),
                ]);

                return response()->json(['status' => 'success', 'result' => $buat]);
                break;
        }

        return abort(404);
    }
}
