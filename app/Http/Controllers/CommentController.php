<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function destroy(Comment $comment)
    {
        // Pastikan hanya pemilik komentar yang bisa menghapus
        if (Auth::id() !== $comment->user_id) {
            abort(403, 'Akses ditolak.');
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Komentar berhasil dihapus.');
    }
}