<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // Validasi input dari user
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Simpan ke tabel users
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email, // Simpan alamat di tabel users
            'password' => Hash::make($request->password),
        ]);

        // Login otomatis
        Auth::login($user);

        // Redirect ke halaman utama atau dashboard setelah registrasi
        return redirect()->route('das')->with('success', 'Registrasi berhasil! Silakan login.');

    }
}
