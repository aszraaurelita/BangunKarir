<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Post;


class ProfileController extends Controller
{
    public function setup()
    {
        $user = Auth::user();
        
        // Jika profil sudah lengkap, redirect ke halaman profil
        if ($user->profile && $user->profile->is_complete) {
            return redirect()->route('profile.show')->with('info', 'Profil Anda sudah lengkap!');
        }
        
        // Pastikan $profile selalu didefinisikan, bahkan jika null
        $profile = $user->profile;
        if (!$profile) {
            $profile = new Profile(); // Buat instance kosong jika belum ada profil
        }
        
        $prodiOptions = Profile::getProdiOptions();
        
        return view('profile.setup', compact('profile', 'prodiOptions'));
    }

    public function store(Request $request)
    {
        Log::info('Profile store started', [
            'user_id' => Auth::id(),
            'request_data' => $request->except(['photo', '_token'])
        ]);

        $user = Auth::user();
        $existingProfileId = $user->profile ? $user->profile->id : null;
        
        // Validasi NIM hanya jika belum pernah diisi atau berbeda dari yang sudah ada
        $nimRule = 'required|string';
        if (!$user->profile || !$user->profile->nim) {
            $nimRule .= '|unique:profiles,nim';
        } elseif ($request->nim !== $user->profile->nim) {
            $nimRule .= '|unique:profiles,nim,' . $existingProfileId;
        }
        
        try {
            $validatedData = $request->validate([
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'nim' => $nimRule,
                'prodi' => 'required|string|in:' . implode(',', array_keys(Profile::getProdiOptions())),
                'semester' => 'required|integer|min:1|max:14',
                'ringkasan_pribadi' => 'nullable|string|max:1000',
                'kontak_email' => 'required|email|max:255',
                'riwayat_prodi' => 'required|string|in:' . implode(',', array_keys(Profile::getProdiOptions())),
                'tahun_masuk' => 'required|integer|min:2000|max:' . date('Y'),
                'ipk' => 'required|numeric|min:0|max:4',
                'bidang_minat' => 'required|string|max:255',
                'perusahaan_impian' => 'required|string|max:255',
            ], [
                'nim.required' => 'NIM wajib diisi.',
                'nim.unique' => 'NIM sudah terdaftar.',
                'prodi.required' => 'Program Studi wajib dipilih.',
                'prodi.in' => 'Program Studi tidak valid.',
                'semester.required' => 'Semester wajib diisi.',
                'kontak_email.required' => 'Email kontak wajib diisi.',
                'kontak_email.email' => 'Format email tidak valid.',
                'riwayat_prodi.required' => 'Riwayat Program Studi wajib dipilih.',
                'riwayat_prodi.in' => 'Riwayat Program Studi tidak valid.',
                'tahun_masuk.required' => 'Tahun masuk wajib diisi.',
                'ipk.required' => 'IPK wajib diisi.',
                'ipk.numeric' => 'IPK harus berupa angka.',
                'ipk.max' => 'IPK maksimal 4.00.',
                'bidang_minat.required' => 'Bidang minat wajib diisi.',
                'perusahaan_impian.required' => 'Perusahaan impian wajib diisi.',
            ]);

            Log::info('Validation passed', ['validated_data' => $validatedData]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', [
                'errors' => $e->errors(),
                'input' => $request->except(['photo', '_token'])
            ]);
            return back()->withErrors($e->errors())->withInput();
        }

        try {
            $profileData = $request->except('photo');
            $profileData['user_id'] = $user->id;
            $profileData['is_complete'] = true;

            Log::info('Profile data prepared', ['profile_data' => $profileData]);

            // Handle photo upload
            if ($request->hasFile('photo')) {
                Log::info('Photo upload detected');
                
                // Delete old photo if exists
                if ($user->profile && $user->profile->photo) {
                    Storage::disk('public')->delete($user->profile->photo);
                    Log::info('Old photo deleted');
                }
                
                $photoPath = $request->file('photo')->store('profile-photos', 'uploads');
                $profileData['photo'] = $photoPath;
                Log::info('New photo uploaded', ['path' => $photoPath]);
            }

            if ($user->profile) {
                Log::info('Updating existing profile', ['profile_id' => $user->profile->id]);
                $user->profile->update($profileData);
                Log::info('Profile updated successfully');
            } else {
                Log::info('Creating new profile');
                $profile = Profile::create($profileData);
                Log::info('Profile created successfully', ['profile_id' => $profile->id]);
            }

            Log::info('Profile store completed successfully');
            return redirect()->route('profile.show')->with('success', 'Profil berhasil disimpan!');
            
        } catch (\Exception $e) {
            Log::error('Profile store failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id()
            ]);
            
            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat menyimpan profil: ' . $e->getMessage(),
            ])->withInput();
        }
    }

    public function show()
    {
        $user = Auth::user();
        $profile = $user->profile;
        // Ambil semua postingan yang dibuat oleh pengguna
        $posts = Post::with(['user', 'likes', 'comments.user'])->where('user_id', $user->id)->latest()->get();
        return view('profile.show', compact('user', 'profile', 'posts'));
    }

    public function edit()
    {
        $user = Auth::user();
        $profile = $user->profile;

        if (!$profile) {
            return redirect()->route('profile.setup')->with('info', 'Silakan lengkapi profil Anda terlebih dahulu.');
        }

        $prodiOptions = Profile::getProdiOptions();

        return view('profile.edit', compact('profile', 'prodiOptions'));
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'photo.required' => 'Foto wajib dipilih.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.mimes' => 'Format foto harus jpeg, png, jpg, atau gif.',
            'photo.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        try {
            $user = Auth::user();
            $profile = $user->profile;

            if (!$profile) {
                return back()->withErrors(['error' => 'Profil tidak ditemukan.']);
            }

            // Delete old photo if exists
            if ($profile->photo) {
                Storage::disk('public')->delete($profile->photo);
            }

            // Upload new photo
            $photoPath = $request->file('photo')->store('profile-photos', 'uploads');
            $profile->update(['photo' => $photoPath]);

            return back()->with('success', 'Foto profil berhasil diperbarui!');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat mengupload foto.']);
        }
    }
    
}
