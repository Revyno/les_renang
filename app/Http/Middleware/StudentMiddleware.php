<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!Auth::user()->isStudent()) {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman tersebut');
        }

        

        return $next($request);
    }
}