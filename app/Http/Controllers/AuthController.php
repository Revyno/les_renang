<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Session-based auth for the public site (Inertia + React pages). Independent of
 * the Filament admin panel, which uses its own guard/login under /admin.
 */
class AuthController extends Controller
{
    public function showLogin(): Response
    {
        return Inertia::render('Auth/Login', [
            'meta' => ['title' => 'Masuk', 'description' => 'Masuk ke akun Les Renang Anda.'],
        ]);
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'Email atau kata sandi salah.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended('/');
    }

    public function showRegister(): Response
    {
        return Inertia::render('Auth/Register', [
            'meta' => ['title' => 'Daftar Akun', 'description' => 'Buat akun Les Renang untuk mulai mendaftar program.'],
        ]);
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('/');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
