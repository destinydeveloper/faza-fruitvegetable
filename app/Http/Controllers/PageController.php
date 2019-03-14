<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index($no)
    {
        $no = $no+10;
        return "Anda sedang di halaman ke-" . $no;
    }
}
