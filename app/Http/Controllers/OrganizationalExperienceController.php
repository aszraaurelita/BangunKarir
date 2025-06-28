<?php

namespace App\Http\Controllers;

use App\Models\OrganizationalExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class OrganizationalExperienceController extends Controller
{
    public function show($id)
    {
        $experience = OrganizationalExperience::findOrFail($id);
        $posts = Post::with(['user', 'likes', 'comments.user'])->latest()->get();
        $user = $experience->user; // agar variabel user dikenal di view
        return view('profile.show', compact('user', 'posts', 'experience'));
    }

    public function index()
    {
        return OrganizationalExperience::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama_organisasi' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'tanggal_masuk' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_masuk',
            'deskripsi_kegiatan' => 'nullable|string',
        ]);

        OrganizationalExperience::create([
        'user_id' => Auth::id(), // lebih aman pakai dari auth
        'nama_organisasi' => $request->nama_organisasi,
        'jabatan' => $request->jabatan,
        'tanggal_masuk' => $request->tanggal_masuk,
        'tanggal_selesai' => $request->tanggal_selesai,
        'deskripsi_kegiatan' => $request->deskripsi_kegiatan,
    ]);

        return redirect()->back()->with('success_organization', 'Pengalaman Organisasi berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $experience = OrganizationalExperience::findOrFail($id);

        $experience->update($request->all());

        return redirect()->back()->with('success_organization', 'Pengalaman Organisasi berhasil diupdate.');
    }

    public function destroy($id)
    {
        $experience = OrganizationalExperience::findOrFail($id);
        $experience->delete();

        return redirect()->back()->with('success_organization', 'Pengalaman Organisasi berhasil dihapus.');
    }

}
