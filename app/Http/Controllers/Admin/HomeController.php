<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Index Default Methods
     */
    public function index()
    {
        return view('admin.home');
    }
    
    /**
     * Get Info Auth - Admin
     * 
     * @return view
     */
    public function info()
    {
        $data = [
            'USER' => Auth()->user(),
            'USER ROLE' => Auth()->user()->role(),
            'USER ROLE EXTRA INFO' => Auth()->user()->info
        ];
        return "a : " . print_r($data);
    }
}
