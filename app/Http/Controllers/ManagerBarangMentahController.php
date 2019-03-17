<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManagerBarangMentahController extends Controller
{
    public function index()
    {
        return view('user.manager.barang_mentah');
    }
}
