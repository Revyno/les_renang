<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Logic untuk menampilkan daftar pengguna
        return view('users.index');
    }

    public function create()
    {
        if (auth()->user()->role != 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
        // Logic untuk menampilkan form pembuatan pengguna baru
        return view('users.create');
    }
      public function show($id)
    {
        return view('user.profile', [
            'user' => User::findOrFail($id)
        ]);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = 'student'; // Atau 'admin' sesuai
        // Logic untuk menyimpan pengguna baru ke database
        // Validasi dan simpan data pengguna
    }

    public function edit($id)
    {
        // Logic untuk menampilkan form edit pengguna
        return view('users.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Logic untuk memperbarui data pengguna di database
        // Validasi dan perbarui data pengguna
    }

    public function destroy($id)
    {  
        if (auth()->user()->id == $id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }
        else {
            return redirect()->route('users.index')->with('success', 'Akun berhasil dihapus.');
        }
        // Logic untuk menghapus pengguna dari database
    }
}
