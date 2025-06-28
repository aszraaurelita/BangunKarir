@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Buat Postingan</h4>

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Caption / isi teks --}}
        <div class="mb-3">
            <label for="caption" class="form-label">Isi Postingan</label>
            <textarea name="caption" class="form-control" rows="4" placeholder="Tulis cerita, prestasi, atau pengalaman...">{{ old('caption') }}</textarea>
        </div>

        {{-- Upload media --}}
        <div class="mb-3">
            <label for="media" class="form-label">Tambahkan Media (Opsional)</label>
            <input type="file" name="media" class="form-control" accept="image/*,video/*,.pdf">
            <div class="form-text">Hanya file JPG, PNG, MP4, atau PDF. Maksimal 20MB.</div>
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn btn-primary">Posting</button>
        <a href="{{ route('profile.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
