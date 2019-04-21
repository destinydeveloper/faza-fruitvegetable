<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BiayaOperasionalController extends Controller
{
    public function index()
    {
        return view('user.biaya_operasional');
    }
}
