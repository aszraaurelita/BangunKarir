<?php

namespace App\Http\Controllers;

use App\Models\WorkExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class WorkExperienceController extends Controller
{
    public function show($id)
    {
        $workExperience = WorkExperience::findOrFail($id);
        $posts = Post::with(['user', 'likes', 'comments.user'])->latest()->get();
        $user = $workExperience->user;
        return view('profile.show', compact('user', 'posts', 'workExperience'));
    }

    public function index() {
        return WorkExperience::all();
    }

   public function store(Request $request)
{
    // Validasi data input, tidak perlu validasi 'user_id' dari request
    $request->validate([
        'nama_perusahaan' => 'required|string|max:255',
        'posisi' => 'required|string|max:255',
        'deskripsi_kerja' => 'nullable|string',
        'lama_waktu' => 'nullable|string',
    ]);

    // Simpan data ke database
    WorkExperience::create([
        'user_id' => Auth::id(), // lebih aman pakai dari auth
        'nama_perusahaan' => $request->nama_perusahaan,
        'posisi' => $request->posisi,
        'deskripsi_kerja' => $request->deskripsi_kerja,
        'lama_waktu' => $request->lama_waktu,
    ]);

    // Kembali ke halaman sebelumnya dengan pesan sukses
    return redirect()->back()->with('success_work', 'Pengalaman kerja berhasil ditambahkan.');
}

    public function update(Request $request, $id) {
        $experience = WorkExperience::findOrFail($id);
        $experience->update($request->all());
        return redirect()->back()->with('success_work', 'Pengalaman kerja berhasil diupdate.');
    }

    public function destroy($id) {
        $experience = WorkExperience::findOrFail($id);
        $experience->delete();
        return redirect()->back()->with('success_work', 'Pengalaman kerja berhasil dihapus.');
    }
}
