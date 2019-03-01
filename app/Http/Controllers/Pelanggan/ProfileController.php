<?php

namespace App\Http\Controllers\Pelanggan;

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

        // kasih view tampilan
        return view('pelanggan.profile', ['user' => $usernya]);
    }
}