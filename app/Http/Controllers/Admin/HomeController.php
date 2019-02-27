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
        return "user - admin home page";
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
            'USER ROLE EXTRA INFO' => Auth()->user()->info
        ];
        dd($data);
    }
}
