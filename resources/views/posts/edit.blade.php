@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Edit Postingan</h4>

    {{-- Form Update --}}
    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Caption --}}
        <div class="mb-3">
            <label for="caption" class="form-label">Isi Postingan</label>
            <textarea name="caption" id="caption" class="form-control" rows="4" required>{{ old('caption', $post->caption) }}</textarea>
        </div>

        {{-- Tampilkan Media Saat Ini --}}
        @if ($post->media_path)
        <div class="mb-3">
            <label class="form-label">Media Saat Ini</label>
            <div class="border p-2 rounded mb-2">
            @php
                $mediaUrl = env('SUPABASE_PUBLIC') . $post->media_path;
            @endphp
                @if ($post->media_type === 'image')
                    <img src="{{ $mediaUrl }}" class="img-fluid rounded">
                @elseif ($post->media_type === 'video')
                    <video controls class="w-100">
                        <source src="{{ $mediaUrl }}">
                    </video>
                @elseif ($post->media_type === 'pdf')
                    <iframe src="{{ $mediaUrl }}" width="100%" height="400px"></iframe>
                @else
                    <p class="text-muted">Format media tidak dikenali.</p>
                @endif
            </div>
        </div>
        @endif

        {{-- Ganti Media --}}
        <div class="mb-3">
            <label for="media" class="form-label">Ganti Media (opsional)</label>
            <input type="file" name="media" id="media" class="form-control" accept="image/*,video/*,application/pdf">
            <small class="text-muted">Kosongkan jika tidak ingin mengganti media.</small>
        </div>

        {{-- Tombol --}}
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
            <a href="{{ route('profile.index') }}" class="btn btn-secondary">❌ Batal</a>
        </div>
    </form>
</div>
@endsection
