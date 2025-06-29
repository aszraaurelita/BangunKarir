<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function showLogin()
    {
        // Jika user sudah login, redirect ke halaman yang sesuai
        if (Auth::check()) {
            return $this->redirectBasedOnProfile();
        }
        
        return view('auth.login');
    }

    public function showRegister()
    {
        // Jika user sudah login, redirect ke halaman yang sesuai
        if (Auth::check()) {
            return $this->redirectBasedOnProfile();
        }
        
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            // Redirect berdasarkan status profil
            return $this->redirectBasedOnProfile();
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::min(8)],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            Auth::login($user);

            // User baru selalu diarahkan ke setup profil
            return redirect()->route('profile.setup')->with('success', 'Registrasi berhasil! Silakan lengkapi profil Anda.');
            
        } catch (\Exception $e) {
            return back()->withErrors([
                'email' => 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.',
            ])->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }

    /**
     * Redirect user berdasarkan status profil
     */
    private function redirectBasedOnProfile()
    {
        $user = Auth::user();

        if (!$user->profile || !$user->profile->is_complete) {
            return redirect()->route('profile.setup');
        }

        return redirect()->route('beranda');
    }



}