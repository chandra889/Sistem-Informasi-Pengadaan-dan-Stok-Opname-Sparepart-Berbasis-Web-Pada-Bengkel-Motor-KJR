<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Form Login
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    // Proses Login (Hanya Admin dan Owner)
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $user = Auth::user();

            // Cek apakah role user adalah 'admin' atau 'owner'
            if (in_array($user->role, ['admin', 'owner'])) {
                $request->session()->regenerate(); // Mencegah Session Fixation Attack
                return redirect()->intended('/')->with('success', 'Selamat datang kembali, ' . ucfirst($user->role) . '!');
            }

            // Jika role bukan admin/owner, logout seketika dan beri pesan penolakan
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Akses ditolak. Halaman ini hanya dapat diakses oleh Admin atau Owner.',
            ])->onlyInput('email');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // Form Registrasi Pengguna Baru / Admin
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Proses Registrasi (Default diberi role 'admin')
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'nullable|in:admin,owner', // Pilihan role saat registrasi
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role ?? 'admin', // Default ke admin jika tidak dipilih
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Akun berhasil dibuat!');
    }

    // Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }
}