<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PharIo\Manifest\Email;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticated(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password'=> 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)){
            $request->session()->regenerate();

            return redirect('/dashboard')->with('success', 'Login successful');
        }
        
    
    return back()->withErrors([
            'loginError' => 'Email atau password salah'
    ]);
    // protected $redirectTo = '/home';
    
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // }
    
    // public function showLoginForm()
    // {
    //     return view('auth.login');
    // }
}

}