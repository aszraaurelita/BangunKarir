@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Hasil Pencarian Mahasiswa</h4>
        <a href="{{ route('beranda') }}" class="btn btn-secondary">⬅ Kembali ke Beranda</a>
    </div>

    <div class="row">
        @forelse ($users as $user)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        {{-- Foto Profil --}}
                        <div class="mb-3 d-flex justify-content-center">
                            @if ($user->profile?->photo)
                                <img src="{{ asset('storage/' . $user->profile->photo) }}"
                                     class="rounded-circle"
                                     style="width: 80px; height: 80px; object-fit: cover; border: 3px solid #ff6b35;">
                            @else
                                <i class="bi bi-person-circle text-secondary" style="font-size: 80px;"></i>
                            @endif
                        </div>

                        {{-- Nama --}}
                        <h5 class="fw-bold">{{ $user->name }}</h5>

                        {{-- Info Pendidikan --}}
                        <p class="text-muted mb-1">{{ $user->profile->prodi ?? '-' }}</p>
                        <p class="text-muted">Semester {{ $user->profile->semester ?? '-' }}</p>

                        {{-- Minat Karier --}}
                        <p class="mb-1"><strong>Minat:</strong> {{ $user->profile->bidang_minat ?? '-' }}</p>

                        {{-- Keahlian --}}
                        <div class="mb-2">
                            <strong>Keahlian:</strong>
                            <ul class="list-unstyled small mb-0">
                                @forelse($user->skills as $skill)
                                    <li>• {{ $skill->nama_skill }}</li>
                                @empty
                                    <li class="text-muted">Belum ada keahlian</li>
                                @endforelse
                            </ul>
                        </div>

                        {{-- Tombol Profil --}}
                        <a href="{{ route('users.profile', ['id' => $user->id]) }}" class="btn btn-outline-primary btn-sm mt-2">
                            👤 Lihat Profil
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    Mahasiswa dengan kriteria tersebut tidak ditemukan.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
