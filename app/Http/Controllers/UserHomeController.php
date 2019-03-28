<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserHomeController extends Controller
{
    public function index()
    {
        if (Auth()->user()->hasRole('pelanggan')) {
            return redirect()->route('homepage');
        }

        return view('user.home');
    }
}
