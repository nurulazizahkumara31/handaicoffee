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
        // Validasi data login (email dan password)
        $credentials = $request->validate([
            'email' => 'required|email',  // pastikan email valid
            'password' => 'required|string|min:6',  // password harus string dan minimal 6 karakter
        ]);

        // Cek jika ada user yang cocok dengan email yang dimasukkan
        $user = User::where('email', $request->email)->first();

        // Jika user ditemukan dan password valid
        if ($user && Hash::check($request->password, $user->password)) {
            // Melakukan login manual
            Auth::login($user);

            // Regenerasi session untuk keamanan
            $request->session()->regenerate();

            // Redirect ke halaman yang diinginkan setelah login berhasil
            return redirect()->intended('/dashboard');
        }

        // Jika login gagal, kembali ke halaman login dengan pesan error
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
