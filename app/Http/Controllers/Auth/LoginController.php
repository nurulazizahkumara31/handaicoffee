<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;  // Pastikan model User sudah di-import
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
{
    // Validasi data login
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ]);

    // Ambil user berdasarkan email
    $user = User::where('email', $request->email)->first();

    // Cek password dan user_group
    if ($user && Hash::check($request->password, $user->password)) {
        if ($user->user_group !== 'customer') {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->withInput();
        }

        // Login pengguna
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
    }

    // Jika login gagal
    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ])->withInput();
}

    // Proses logout
    public function logout(Request $request)
{
    // Logout pengguna
    Auth::logout();

    // Invalidasi session dan regenerasi token CSRF untuk keamanan
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Redirect ke halaman index setelah logout
    return redirect('/');
}

}
