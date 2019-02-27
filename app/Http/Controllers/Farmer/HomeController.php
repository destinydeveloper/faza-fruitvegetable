<?php

namespace App\Http\Controllers\Farmer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Index Default Methods
     */
    public function index()
    {
        return "user - Farmer home page";
    }
}
