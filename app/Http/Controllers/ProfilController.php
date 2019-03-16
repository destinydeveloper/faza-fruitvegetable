<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\Images;
use App\User;

class ProfilController extends Controller
{
    public function index()
    {
        return view('user.profil');
    }

    public function upload(Request $request)
    {
        $auth_nama = Auth()->user()->nama;
        $auth_id = Auth()->user()->id;

        if ($request->has('profil')) {
            $request->validate([
                'nama' => 'required',
                'email' => 'required|email',
                'username' => 'required',
            ]);
            
            $check = User::whereUsername($request->input('username'))
                ->whereNotIn('username', [Auth()->user()->username])
                ->get();
            if (count($check) > 0) return redirect()->route('user.profil')->with('message', ['danger', 'Username telah digunakan!']);

            $user = User::find($auth_id);
            $user->nama = $request->input('nama');
            $user->email = $request->input('email');
            $user->username = $request->input('username');

            if ($request->has('avatar')) {

                $avatar = Images::upload('avatar', $auth_nama." Avatar", "Image for avatar ".$auth_nama, '100x100');
                $user->gambar_id = $avatar->id;
            }
                        
            $user->save();
            
            return redirect()->route('user.profil')->with('message', ['success', 'Berhasil Diperbarui!']);



        } else if ($request->has('change_password')) {
            $request->validate([
                'password' => 'required|min:6',
                're_password' => 'required_with:password|same:password'
            ]);

            $user = User::find($auth_id);
            $user->password = bcrypt($request->input('password'));
            $user->save();
        

            return redirect()->route('user.profil')->with('message', ['success', 'Password Diperbarui!']);
        }

        return abort(404);
    }
}