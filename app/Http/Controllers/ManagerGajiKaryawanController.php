<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;

use App\User;
use App\Models\GajiKaryawan;

class ManagerGajiKaryawanController extends Controller
{
    public function index(Request $request)
    {        
        if ($request->ajax()) return $this->getAll();
        return view('user.manager.gajikaryawan');
    }

    public function getAll()
    {
        return DataTables::of(GajiKaryawan::with(['user', 'user.roles'])->whereHas('user.roles', function($q) {
                        return $q->where('name', app()->request->input('filter'));
                    }))
                ->addColumn('no', function(){
                    static $no = 1;
                    return $no++;
                })
                ->addColumn('action', function($u){
                    $id = $u->id;
                    $name = "'".$u->user->nama."'";
                    return '
                        <button onclick="app.detail('.$id.')" title="Lihat" class="btn btn-xs btn-success"><i class="fa fa-search"></i></button>
                        <button onclick="app.edit('.$u->id.')" title="Edit" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></button>
                        <button onclick="app.delete('.$id.', '.$name.')" title="Hapus" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                    ';
                })
                ->make(true);
    }

    public function action(Request $request)
    {
        if (!$request->has('action')) return $this->errResponse('action not found');
        if (!$request->has('filter') && $request->input('action') == 'getlistuser' ) return $this->errResponse('filter not found');
        if (!$request->has('id') && ($request->input('action') != 'addnew' and $request->input('action') !=  'getlistuser')) return $this->errResponse('id not found');

        switch ($request->input('action'))
        {
            
            case 'detail':
                $user = GajiKaryawan::with('user', 'user.avatar')->find($request->input('id'));
                if ($user === null) return $this->errResponse("search result not found");
                return response()->json(['status' => 'success', 'result' => $user], 200);
                break;
            
            case 'getlistuser':
                $user = User::with('roles')->whereHas('roles', function($q) {
                    return $q->where('name', app()->request->input('filter'));
                })->get();

                if ($user === null or count($user) == 0) return $this->errResponse("search result not found");
                return response()->json(['status' => 'success', 'result' => $user], 200);
                break;

                case 'delete':
                $user = GajiKaryawan::find($request->input('id'));
                $delete = $user->delete();

                return response()->json(['status' => 'success', 'result' => $request->input('id')]);
                break;

            case 'update':
                $request->validate([
                    'id' => 'required|integer',
                    'gaji_pokok' => 'required|integer',
                    'tunjangan' => 'required|integer',
                    'bonus' => 'required|integer',
                ]);

                $gaji = GajiKaryawan::find($request->input('id'));
                // return response()->json(['status' => 'success', 'result' => $gaji]);
                $gaji->gaji_pokok = $request->input('gaji_pokok');
                $gaji->tunjangan = $request->input('tunjangan');
                $gaji->bonus = $request->input('bonus');
                $gaji->save();

                return response()->json(['status' => 'success', 'result' => $gaji->id]);
                break;

            case 'addnew':
                $request->validate([
                    'id' => 'required|integer',
                    'nama' => 'required',
                    'gaji_pokok' => 'required|integer',
                    'tunjangan' => 'required|integer',
                    'bonus' => 'required|integer',
                ]);

                $ceck = GajiKaryawan::where('user_id', $request->input('id'))->count();
                if ($ceck > 0) return $this->errResponse("user sudah memiliki data gaji");

                $gaji = new GajiKaryawan();
                $gaji->user_id = $request->input('id');
                $gaji->gaji_pokok = $request->input('gaji_pokok');
                $gaji->tunjangan = $request->input('tunjangan');
                $gaji->bonus = $request->input('bonus');
                $gaji->save();

                return response()->json(['status' => 'success', 'result' => $gaji->id], 200);
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
