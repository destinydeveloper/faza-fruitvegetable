<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HalamanBantuanController extends Controller
{
    public function index()
    {
        return view('user.halaman.bantuan');
    }

    public function baru()
    {
        return view('user.halaman.bantuan_detail');
    }
}
