<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        echo"selamat datang di halaman home";
        return view('home');
    }
    
}