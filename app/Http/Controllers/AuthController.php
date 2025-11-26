<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Temukan pengguna berdasarkan email
        $user = User::where('email', $credentials['email'])->first();

        if ($user) {
        // Periksa apakah pengguna aktif
        if ($user->is_active != 1) {
            return back()->with('error', 'Akun Anda tidak aktif.');
        }

        // Coba login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('admin/dashboard');
        }
        }

        return back()->with('error', 'Login gagal. Periksa kembali Email dan Password');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Anda telah logout.');
    }
}
