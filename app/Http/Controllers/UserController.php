<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
class UserController extends Controller
{
    public function show($id)
{
    $user = User::findOrFail($id);
    $profile = $user->profile;
    $posts = Post::with(['user', 'likes', 'comments.user'])->where('user_id', $user->id)->latest()->get();

    return view('profile.user', compact('user', 'profile', 'posts'));
}

    public function search(Request $request)
{
    $query = User::with(['profile', 'skills']);

    if ($request->filled('nama')) {
        $query->where('name', 'like', '%' . $request->nama . '%');
    }

    if ($request->filled('prodi')) {
        $query->whereHas('profile', fn ($q) => $q->where('prodi', $request->prodi));
    }

    if ($request->filled('interest')) {
        $query->whereHas('profile', fn ($q) => $q->where('bidang_minat', $request->interest));
    }

    if ($request->filled('skill')) {
        $query->whereHas('skills', fn ($q) => $q->where('id', $request->skill));
    }

    $users = $query->get();

    return view('users.search_results', compact('users'));
}

}

