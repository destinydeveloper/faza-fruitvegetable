<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class ProfileController extends Controller
{
    public function index($username)
    {
        // Cari User di Database menurut username yang dicari
        $usernya = User::where('username', $username)->first();
        if ($usernya === null) return abort(404);

        $html = '
            ditemukan! user yang anda cari ['. $username .'] ada di database dengan nama 
            <b>'. $usernya->name .'</b> dan <b>email '. $usernya->email .'</b>
        ';

        return $html;
    }
}