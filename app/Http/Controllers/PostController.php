<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use App\Models\Comment; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;
    // Menampilkan semua postingan
    public function index(Request $request)
    {
        $posts = Post::with(['user', 'likes', 'comments.user'])->latest()->get();
        $highlight = $request->highlight;
        return view('profile.index', compact('posts', 'highlight'));
    }

    // Form buat postingan
    public function create()
    {
        return view('posts.create');
    }

    // Simpan postingan
    public function store(Request $request)
    {
        $request->validate([
            'caption' => 'nullable|string',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,mp4,pdf|max:20480', // max 20MB
        ]);

        $mediaPath = null;
        $mediaType = null;

        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $mediaPath = $file->store('posts', 'public');

            $ext = $file->getClientOriginalExtension();
            if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                $mediaType = 'image';
            } elseif ($ext === 'mp4') {
                $mediaType = 'video';
            } elseif ($ext === 'pdf') {
                $mediaType = 'pdf';
            }
        }

        Post::create([
            'user_id' => Auth::id(),
            'caption' => $request->caption,
            'media_path' => $mediaPath,
            'media_type' => $mediaType,
        ]);

        return redirect()->route('profile.index')->with('success', 'Postingan berhasil ditambahkan.');
    }

    // Edit teks postingan
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    // Update hanya teks
    public function update(Request $request, Post $post)
{
    $request->validate([
        'caption' => 'required|string',
        'media' => 'nullable|file|mimes:jpg,jpeg,png,mp4,pdf|max:10240', // max 10MB
    ]);

    $post->caption = $request->caption;

    if ($request->hasFile('media')) {
        // Hapus media lama
        if ($post->media_path && Storage::exists($post->media_path)) {
            Storage::delete($post->media_path);
        }

        // Simpan media baru
        $path = $request->file('media')->store('media', 'public');
        $post->media_path = $path;

        // Deteksi jenis media
        $mime = $request->file('media')->getMimeType();
        if (str_contains($mime, 'image')) {
            $post->media_type = 'image';
        } elseif (str_contains($mime, 'video')) {
            $post->media_type = 'video';
        } elseif (str_contains($mime, 'pdf')) {
            $post->media_type = 'pdf';
        }
    }

    $post->save();

    return redirect(url()->previous())->with('success', 'Postingan berhasil diperbarui.');
}

    // Hapus postingan + media
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        if ($post->media_path) {
            Storage::disk('public')->delete($post->media_path);
        }

        $post->delete();

        return redirect()->route('profile.index')->with('success', 'Postingan berhasil dihapus.');
    }

    // Like atau Unlike
    public function like(Post $post)
    {
        $like = $post->likes()->where('user_id', Auth::id())->first();

        if ($like) {
            $like->delete();
        } else {
            $post->likes()->create(['user_id' => Auth::id()]);
        }

        return redirect()->back()->withFragment('post-' . $post->id);
    }

    // Tambah Komentar
    public function comment(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $post->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return back();
    }
    
    public function commentPage(Post $post)
    {
        return view('posts.comments', compact('post'));
    }

    public function showComments(Post $post)
{
    $comments = $post->comments()->latest()->get(); // atau dengan pagination

    return view('posts.comments', compact('post', 'comments'));
}
}
