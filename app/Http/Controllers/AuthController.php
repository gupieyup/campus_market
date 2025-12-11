<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show login form (optional, existing route may return view directly)
     */
    public function showLogin()
    {
        return view('Pengunjung.Login');
    }

    /**
     * Handle login attempt and redirect based on role
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $email = $credentials['email'];
        $password = $credentials['password'];
        $remember = $request->filled('remember');

        $user = User::where('email', $email)->first();

        if (! $user) {
            Log::warning('Login gagal: email tidak ditemukan', ['email' => $email, 'ip' => $request->ip()]);
            return back()->withErrors(['email' => 'Email belum terdaftar. Silakan periksa kembali atau daftar akun baru.'])->onlyInput('email');
        }

        // Periksa password manual supaya kita bisa beri pesan yang lebih jelas untuk debugging
        if (! Hash::check($password, $user->password)) {
            Log::warning('Login gagal: password salah', ['email' => $email, 'user_id' => $user->id, 'ip' => $request->ip()]);
            return back()->withErrors(['email' => 'Password tidak cocok. Pastikan password Anda benar.'])->onlyInput('email');
        }

        // Jika sampai sini, kredensial benar -> login
        Auth::login($user, $remember);
        $request->session()->regenerate();

        // Redirect based on role value in users table
        if (isset($user->role) && $user->role === 'Admin') {
            return redirect()->intended('/dashboard-admin');
        }

        return redirect()->intended(route('seller.dashboard'));
    }

    /**
     * Logout the user
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman home setelah logout
        return redirect('/')->with('success', 'Anda telah berhasil logout.');
    }
}
