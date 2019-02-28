<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Index Default Methods
     */
    public function index($username)
    {
        return "anda sedang berada pada user : " . $username;
    }
}
