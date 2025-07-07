@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h4>Semua Postingan Mahasiswa</h4>

    @forelse ($posts as $post)
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <strong>{{ $post->user->name }}</strong>
                    <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                </div>

                <p class="mt-2">{{ $post->caption }}</p>

                {{-- Media --}}
                @php
                    $mediaUrl = env('SUPABASE_PUBLIC') . $post->media_path;
                @endphp

                @if ($post->media_path)
                    <div class="mt-3">
                        @if ($post->media_type === 'image')
                            <img src="{{ $mediaUrl }}" class="img-fluid rounded">
                        
                        @elseif ($post->media_type === 'video')
                            <video controls class="w-100 rounded">
                                <source src="{{ $mediaUrl }}">
                            </video>
                        
                        @elseif ($post->media_type === 'pdf')
                            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#pdfModal-{{ $post->id }}">
                                📄 Lihat Dokumen
                            </button>

                            {{-- Modal Preview PDF --}}
                            <div class="modal fade" id="pdfModal-{{ $post->id }}" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Pratinjau Dokumen</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body" style="height: 80vh;">
                                            <iframe src="{{ $mediaUrl }}" width="100%" height="100%" style="border: none;"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif


                {{-- Like & Komentar Count --}}
                <div class="mt-2 d-flex justify-content-between">
                    <span>{{ $post->likes->count() }} Like</span>
                    <span>{{ $post->comments->count() }} Komentar</span>
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted">Belum ada postingan yang tersedia.</p>
    @endforelse
</div>
@endsection
