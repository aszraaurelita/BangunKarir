<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Profile;

class LandingController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $userId = Auth::id();
            $profile = Profile::where('user_id', $userId)->first();

            if ($profile && $profile->is_complete) {
                return redirect('/beranda');
            }

            return redirect('/profile/setup');
        }

        return view('landing.index'); // tampilkan halaman landing untuk guest
    }
}