@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <a href="{{ route('beranda', ['highlight' => $post->id]) }}" class="btn btn-secondary mb-3">⬅ Kembali ke Beranda</a>
    <h4>Komentar untuk Postingan</h4>

    <div class="card mb-3">
        <div class="card-body">
            <strong>{{ $post->user->name }}</strong>
            <p>{{ $post->caption }}</p>
            {{-- Tampilkan media jika ada --}}
            @if ($post->media_path)
                <div class="mt-3">
                    @if ($post->media_type === 'image')
                        <img src="{{ $post->media_path }}" class="img-fluid rounded">
                    
                    @elseif ($post->media_type === 'video')
                        <video controls class="w-100 rounded">
                            <source src="{{ $post->media_path }}">
                        </video>
                    
                    @elseif ($post->media_type === 'pdf')
                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#pdfModal-{{ $post->id }}">
                            📄 Lihat Dokumen
                        </button>

                        {{-- Modal untuk preview PDF --}}
                        <div class="modal fade" id="pdfModal-{{ $post->id }}" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Pratinjau Dokumen</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                    </div>
                                    <div class="modal-body" style="height: 80vh;">
                                        <iframe src="{{ $post->media_path }}" width="100%" height="100%" style="border: none;"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    {{-- Daftar Komentar --}}
    <h5>Komentar</h5>

        @foreach ($post->comments as $comment)
        <div class="border-bottom py-2 d-flex justify-content-between align-items-center">
            <div>
                <strong>{{ $comment->user->name }}</strong>
                <p class="mb-1">{{ $comment->content }}</p>
            </div>

            @if (Auth::id() === $comment->user_id)
                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus komentar ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" title="Hapus">
                        🗑 Hapus
                    </button>
                </form>
            @endif
        </div>
    @endforeach


        {{-- ⬇️ Form kirim komentar --}}
        <form action="{{ route('posts.comment', $post) }}" method="POST" class="mt-3">
            @csrf
            <div class="input-group">
                <input type="text" name="content" class="form-control" placeholder="Tulis komentar..." required>
                <button type="submit" class="btn btn-primary">Kirim</button>
            </div>
    </form>

</div>
@endsection