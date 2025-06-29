<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use App\Models\Profile;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        try {
            return Socialite::driver('google')->redirect();
        } catch (\Exception $e) {
            Log::error('Google redirect error', ['error' => $e->getMessage()]);
            return redirect()->route('login')->with('error', 'Terjadi kesalahan saat menghubungkan ke Google.');
        }
    }

    public function handleGoogleCallback()
    {
        try {
            // Log session data sebelum memproses callback (POSISI YANG TEPAT)
            Log::info('Session data before Google callback', [
                'session_id' => session()->getId(),
                'session_data' => session()->all(),
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]);
            $googleUser = Socialite::driver('google')->user();
            
            // Cek apakah user sudah ada berdasarkan Google ID
            $user = User::where('google_id', $googleUser->id)->first();
            
            if ($user) {
                // User sudah ada, login langsung
                Auth::login($user);
                Log::info('Existing Google user logged in', ['user_id' => $user->id]);
            } else {
                // Cek apakah email sudah terdaftar
                $existingUser = User::where('email', $googleUser->email)->first();
                
                if ($existingUser) {
                    // Update user yang sudah ada dengan Google ID
                    $existingUser->update([
                        'google_id' => $googleUser->id,
                        'avatar' => $googleUser->avatar,
                    ]);
                    Auth::login($existingUser);
                    Log::info('Existing user linked with Google', ['user_id' => $existingUser->id]);
                } else {
                    // Buat user baru
                    $user = User::create([
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                        'avatar' => $googleUser->avatar,
                        'password' => Hash::make(Str::random(24)), // Random password
                        'email_verified_at' => now(),
                    ]);
                    Auth::login($user);
                    Log::info('New Google user created', ['user_id' => $user->id]);
                }
            }
            
            // Redirect berdasarkan status profil
            return $this->redirectBasedOnProfile();
            
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            Log::error('Google OAuth state error', ['error' => $e->getMessage()]);
            return redirect()->route('login')->with('error', 'Sesi Google OAuth tidak valid. Silakan coba lagi.');
        } catch (\Exception $e) {
            Log::error('Google callback error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('login')->with('error', 'Terjadi kesalahan saat login dengan Google. Silakan coba lagi.');
        }
    }

    /**
     * Redirect user berdasarkan status profil
     */
    private function redirectBasedOnProfile()
    {
        $user = Auth::user();

        $profile = Profile::where('user_id', $user->id)->first();

        if (!$user->profile || !$user->profile->is_complete) {
            return redirect()->route('profile.setup')->with('success', 'Berhasil login dengan Google! Silakan lengkapi profil Anda.');
        }

        return redirect()->route('beranda')->with('success', 'Berhasil login dengan Google!');
    }


}
