<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class ProjectExperienceController extends Controller
{
    public function show($id)
    {
        $project = Project::findOrFail($id);
        $posts = Post::with(['user', 'likes', 'comments.user'])->latest()->get();
        $user = $project->user;
        return view('profile.show', compact('user', 'posts', 'project'));
    }

    public function index() {
        return Project::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama_proyek' => 'required|string|max:255',
            'deskripsi_proyek' => 'nullable|string',
            'tanggal_pelaksanaan' => 'nullable|date',
            'tautan' => 'nullable|url',
        ]);

         Project::create([
        'user_id' => Auth::id(), // lebih aman pakai dari auth
        'nama_proyek' => $request->nama_proyek,
        'deskripsi_proyek' => $request->deskripsi_proyek,
        'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
        'tautan' => $request->tautan,
    ]);

    return redirect()->back()->with('success_project', 'Project berhasil ditambahkan.');
    }

    public function update(Request $request, $id) {
        $experience = Project::findOrFail($id);
        $experience->update($request->all());
        return redirect()->back()->with('success_project', 'Project berhasil diupdate.');
    }

    public function destroy($id) {
        $experience = Project::findOrFail($id);
        $experience->delete();
        return redirect()->back()->with('success_project', 'Project berhasil dihapus.');
    }
}
