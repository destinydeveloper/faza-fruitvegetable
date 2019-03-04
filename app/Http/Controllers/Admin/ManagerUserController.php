<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Datatables;

use App\User;

class ManagerUserController extends Controller
{
    public function index(Request $request)
    {
        // return $this->getUser($request);
        if ($request->ajax()) return $this->getUser($request);
        return view('admin.manager.user');
    }

    public function process(Request $request)
    {
        if (!$request->has('action')) return $this->errActionNotFound();
        if (!$request->has('id')) return $this->errIdNotFound();

        switch ($request->input('action'))
        {
            case 'detail':
                $user = User::with('avatar')->whereId($request->input('id'))->first();
                if ($user === null) return $this->errNotFound();
                return response()->json(['status' => 'success', 'result' => $user], 200);
                break;

            default:
                if (!$request->has('action')) return $this->errActionNotFound();
                break;
        }
    }

    public function getUser($request)
    {
        switch ($request->input('filter')) 
        {
            case 'admin':
                $data = \App\Models\Admin::query();
                break;

            case 'pelanggan':
                $data = \App\Models\Pelanggan::query();
                break;

            default:
                $data = [];
                break;

        }
        
        return $data === null ? 'null' : 
            Datatables::of($data)
                ->addColumn('nama', function($u){
                    return $u->user->nama;
                })
                ->addColumn('email', function($u){
                    return $u->user->email;
                })
                ->addColumn('action', function($u){
                    $id = $u->user->id;
                    return '
                        <button onclick="app.detail('.$id.')" title="Lihat" class="btn btn-sm btn-success"><i class="fa fa-search"></i></button>
                        <button onclick="app.edit('.$id.')" title="Edit" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></button>
                        <button onclick="app.delete('.$id.')" title="Hapus" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                    ';
                })
                ->make(true);
    }




    /**
     * EROR HANDLE
     */

    private function errActionNotFound()
    {
        $errCode = 200;
        return response()->json(['status'=>'error', 'error' => 'action not found'], $errCode);
    }
    
    private function errNotFound()
    {
        $errCode = 200;
        return response()->json(['status'=>'error', 'error' => 'user not found'], $errCode);
    }

    private function errIdNotFound()
    {
        $errCode = 200;
        return response()->json(['status'=>'error', 'error' => 'id not found'], $errCode);
    }
}
