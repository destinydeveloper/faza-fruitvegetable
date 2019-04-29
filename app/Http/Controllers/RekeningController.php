<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;

use App\Models\Rekening;

class RekeningController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) return $this->getAll();
        return view('user.manager.rekening');
    }

    public function getAll()
    {
        return DataTables::of(Rekening::query())
                ->addColumn('no', function(){
                    static $no = 1;
                    return $no++;
                })
                ->addColumn('nomor', function($u){
                    return $u->no;
                })
                ->addColumn('action', function($u){
                    $id = $u->id;
                    $nama = "'$u->bank'";
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
                $result = Rekening::findOrFail($request->input('id'));
                return response()->json(['status' => 'success', 'result' => $result]);
                break;
            
                case 'update':
                $request->validate([
                    'id' => 'required|integer',
                    'bank' => 'required',
                    'nama' => 'required',
                    'no' =>   'required|integer'
                ]);
                $result = Rekening::findOrFail($request->input('id'));
                $result = $result->update([
                    "nama" => $request->input('nama'),
                    "bank" => $request->input('bank'),
                    "no" => $request->input('no'),
                ]);
                return response()->json(['status' => 'success', 'result' => $result]);
                break;

            case 'addnew':
                $request->validate([
                    'bank' => 'required',
                    'nama' => 'required',
                    'no' =>   'required|integer'
                ]);

                $buat = Rekening::create([
                    "nama" => $request->input('nama'),
                    "bank" => $request->input('bank'),
                    "no" => $request->input('no'),
                ]);

                return response()->json(['status' => 'success', 'result' => $buat]);
                break;
        }

        return abort(404);
    }
}
