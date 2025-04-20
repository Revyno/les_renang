<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // public function login()
    // {
    //     return view('auth.login');
    // }

    use AuthenticatesUsers;
    
    protected $redirectTo = '/home';
    
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function showLoginForm()
    {
        return view('auth.login');
    }
}
