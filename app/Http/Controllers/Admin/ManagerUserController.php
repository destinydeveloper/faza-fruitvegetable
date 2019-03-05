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
        if ($request->ajax()) {
            return Datatables::of(\App\User::whereRoleType('App\\Models\\'.ucfirst($request->input('filter'))))
                ->addColumn('action', function($u){
                    $id = $u->id;
                    $username = "'".$u->username."'";
                    return '
                        <button onclick="app.detail('.$id.')" title="Lihat" class="btn btn-sm btn-success"><i class="fa fa-search"></i></button>
                        <button onclick="app.edit('.$id.')" title="Edit" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></button>
                        <button onclick="app.delete('.$id.', '.$username.')" title="Hapus" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                    ';
                })
                ->make(true);
        }
        return view('admin.manager.tes');
    }






    public function indexa(Request $request)
    {
        if ($request->ajax()) return $this->getUser($request);
        return view('admin.manager.user');
    }

    public function process(Request $request)
    {
        if (!$request->has('action')) return $this->errResponse('action not found');
        if (!$request->has('id') && $request->input('action') != 'addnew') return $this->errResponse('id not found');

        switch ($request->input('action'))
        {
            case 'addnew':
                $user_role = ['admin','investor','petani','pelanggan','kurir','pengepak','supervisor'];
                if (!$request->has('role')) return $this->errResponse('role not found');
                if (!in_array($request->has('role'), $user_role)) return $this->errResponse('role not accepted');
                $role = ucfirst($request->input('role'));
                $request->validate([
                    'nama' => 'required',
                    'email' => 'required',
                    'username' => 'required',
                    'password' => 'required',
                ]);

                $role_model = '\App\\Models\\'.$role;
                $user_level = $role_model::create([]);
                $user = new \App\User();
                $user->nama = $request->input('nama');
                $user->username = $request->input('nama');
                $user->email = $request->input('nama');
                $user->password = bcrypt($request->input('nama'));
                $user_level->user()->save($user);
                
                return response()->json(['status' => 'success', 'result' => $user_level], 200);
                break;

            case 'detail':
                $user = User::with('avatar')->whereId($request->input('id'))->first();
                if ($user === null) return $this->errNotFound();
                return response()->json(['status' => 'success', 'result' => $user], 200);
                break;
            
            case 'delete':
                $user = User::find($request->input('id'));
                $delete = $user->info()->delete();
                $user = User::find($request->input('id'));
                $delete = $user->delete();

                return response()->json(['status' => 'success', 'result' => $request->input('id')]);
                break;

            default:
                if (!$request->has('action')) return $this->errResponse('action not found');
                break;
        }
    }

    public function getUser($request)
    {
        $data = \App\User::whereRoleType('App\\Models\\'.ucfirst($request->input('filter')));
        // return $data === null ? 'null' : 
        //     Datatables::of($data)
        //         ->addColumn('nama', function($u){
        //             return $u->user->nama;
        //         })
        //         ->addColumn('email', function($u){
        //             return $u->user->email;
        //         })
        //         ->addColumn('action', function($u){
        //             $id = $u->user->id;
        //             $username = "'".$u->user->username."'";
        //             return '
        //                 <button onclick="app.detail('.$id.')" title="Lihat" class="btn btn-sm btn-success"><i class="fa fa-search"></i></button>
        //                 <button onclick="app.edit('.$id.')" title="Edit" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></button>
        //                 <button onclick="app.delete('.$id.', '.$username.')" title="Hapus" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
        //             ';
        //         })
        //         ->make(true);
        
        return Datatables::of(User::query())
            ->addColumn('nama', function($u){
                return $u->nama;
            })
            ->addColumn('email', function($u){
                return $u->email;
            })
            ->addColumn('action', function($u){
                $id = $u->id;
                $username = "'".$u->username."'";
                return '
                    <button onclick="app.detail('.$id.')" title="Lihat" class="btn btn-sm btn-success"><i class="fa fa-search"></i></button>
                    <button onclick="app.edit('.$id.')" title="Edit" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></button>
                    <button onclick="app.delete('.$id.', '.$username.')" title="Hapus" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                ';
            })
            ->make(true);
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
