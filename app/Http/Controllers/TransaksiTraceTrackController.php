<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransaksiTraceTrackController extends Controller
{
    public function index()
    {
        return view('user.transaksi.trace_track');
    }
}
