<?php

namespace App\Http\Controllers;

use App\Models\UserSkill;
use Illuminate\Http\Request;
use App\Models\Post;

class SkillController extends Controller
{
    public function show($id)
    {
        $skill = UserSkill::findOrFail($id);
        $posts = Post::with(['user', 'likes', 'comments.user'])->latest()->get();
        $user = $skill->user;
        return view('profile.show', compact('user', 'posts', 'skill'));
    }

    public function index() {
        return UserSkill::all();
    }

    public function store(Request $request)
    {
        $validated= $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama_skill' => 'required|string|max:255',
            'tipe' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $skill = UserSkill::create($validated);

        // 3. Ambil user dari relasi
        $user = $skill->user; // ← pastikan model UserSkill punya relasi belongsTo
         $totalSkills = $user->skills()->count();
        $profileProgress = $user->getProfileCompletionPercentage();

    return redirect()->back()->with('success_skill', 'Skills berhasil ditambahkan.');
    }

    public function update(Request $request, $id) {
        $skill = UserSkill::findOrFail($id);
        $skill->update($request->all());
        return redirect()->back()->with('success_skill', 'Skills berhasil diupdate.');
    }

    public function destroy($id) {
        $skill = UserSkill::findOrFail($id);
        $skill->delete();
        return redirect()->back()->with('success_skill', 'Skills berhasil dihapus.');
    }
}
