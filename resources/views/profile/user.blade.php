@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Profile Header --}}
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4 w-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center position-relative">
                            @if($profile && $profile->photo)
                                <img src="{{ $profile->photo }}" alt="Profile Photo" class="rounded-circle img-fluid" style="width: 200px; height: 200px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto" style="width: 200px; height: 200px;">
                                    <i class="bi bi-person" style="font-size: 4rem; color: #6c757d;"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-9">
                            <h2 class="mb-1">{{ $user->name }}</h2>
                            <p class="text-muted mb-2">{{ $profile->prodi ?? 'Program Studi belum diisi' }} - Semester {{ $profile->semester ?? 'N/A' }}</p>
                            <p class="mb-3">{{ $profile->ringkasan_pribadi ?? 'Belum ada ringkasan pribadi' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="row">
    {{-- Informasi Pribadi --}}
    <div class="col-md-6 mb-4">
        <div class="card shadow w-100">
            <div class="card-header bg-white">
                <h5 class="mb-0">Informasi Pribadi</h5>
            </div>
            <div class="card-body">
                @if($profile)
                    <div class="row mb-2">
                        <div class="col-4"><strong>NIM:</strong></div>
                        <div class="col-8">{{ $profile->nim ?? 'Belum diisi' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><strong>Email:</strong></div>
                        <div class="col-8">{{ $profile->kontak_email ?? $user->email }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><strong>Program Studi:</strong></div>
                        <div class="col-8">{{ $profile->prodi ?? 'Belum diisi' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><strong>Semester:</strong></div>
                        <div class="col-8">{{ $profile->semester ?? 'Belum diisi' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><strong>Tahun Masuk:</strong></div>
                        <div class="col-8">{{ $profile->tahun_masuk ?? 'Belum diisi' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><strong>IPK:</strong></div>
                        <div class="col-8">{{ $profile->ipk ? number_format($profile->ipk, 2) : 'Belum diisi' }}</div>
                    </div>
                @else
                    <p class="text-muted">Profil belum dilengkapi</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Minat & Tujuan Karir --}}
    <div class="col-md-6 mb-4">
        <div class="card shadow h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0">Minat & Tujuan Karir</h5>
            </div>
            <div class="card-body">
                @if($profile)
                    <div class="row mb-3">
                        <div class="col-5"><strong>Bidang Minat:</strong></div>
                        <div class="col-7">{{ $profile->bidang_minat ?? 'Belum diisi' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5"><strong>Perusahaan Impian:</strong></div>
                        <div class="col-7">{{ $profile->perusahaan_impian ?? 'Belum diisi' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5"><strong>Riwayat Prodi:</strong></div>
                        <div class="col-7">{{ $profile->riwayat_prodi ?? 'Belum diisi' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5"><strong>Update Terakhir:</strong></div>
                        <div class="col-7">{{ $profile->updated_at->format('d M Y') }}</div>
                    </div>
                @else
                    <p class="text-muted">Informasi karir belum dilengkapi</p>
                @endif
            </div>
        </div>
    </div>
</div>

    {{-- Profil Lanjutan --}}
    @if($profile && $profile->is_complete)
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Profil Lanjutan</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4 mb-3">
                            <i class="bi bi-building" style="font-size: 2rem; color: #0d6efd;"></i>
                            <h6 class="mt-2">Pengalaman Organisasi</h6>
                            <span class="badge bg-secondary">{{ ($user->organizationalExperiences ?? collect())->count() }} item</span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <i class="bi bi-code-square" style="font-size: 2rem; color: #198754;"></i>
                            <h6 class="mt-2">Proyek</h6>
                            <span class="badge bg-secondary">{{ ($user->projects ?? collect())->count() }} item</span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <i class="bi bi-briefcase" style="font-size: 2rem; color: #fd7e14;"></i>
                            <h6 class="mt-2">Pengalaman Kerja</h6>
                            <span class="badge bg-secondary">{{ ($user->workExperiences ?? collect())->count() }} item</span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <i class="bi bi-gear" style="font-size: 2rem; color: #6f42c1;"></i>
                            <h6 class="mt-2">Skills</h6>
                            <span class="badge bg-secondary">{{ ($user->skills ?? collect())->count() }} item</span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <i class="bi bi-award" style="font-size: 2rem; color: #dc3545;"></i>
                            <h6 class="mt-2">Sertifikat</h6>
                            <span class="badge bg-secondary">{{ ($user->certificates ?? collect())->count() }} item</span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <i class="bi bi-trophy" style="font-size: 2rem; color: #ffc107;"></i>
                            <h6 class="mt-2">Penghargaan</h6>
                            <span class="badge bg-secondary">{{ ($user->achievements ?? collect())->count() }} item</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Pengalaman Organisasi & Proyek --}}
    <div class="row">
        <div class="col-md-6 mb-4">
            {{-- Section Pengalaman Organisasi --}}
            <div class="card shadow h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Pengalaman Organisasi</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Pengalaman organisasi yang dimiliki</p>
                    <div class="mt-3">
                        @forelse ($user->organizationalExperiences ?? [] as $experience)
                            <div class="mb-3 border-bottom pb-2 d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-0">{{ $experience->jabatan }} di {{ $experience->nama_organisasi }}</h6>
                                    <small class="text-muted">
                                    {{ $experience->tanggal_masuk ? $experience->tanggal_masuk->translatedFormat('F Y') : '-' }}
                                    -
                                    {{ $experience->tanggal_selesai ? $experience->tanggal_selesai->translatedFormat('F Y') : 'Sekarang' }}
                                    </small>
                                    @if ($experience->deskripsi_kegiatan)
                                        <p class="mt-2 mb-1">{{ $experience->deskripsi_kegiatan }}</p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <small class="text-muted">Belum ada pengalaman organisasi yang ditambahkan.</small>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            {{-- Section Project --}}
            <div class="card shadow h-100">
                <div class="card-header d-flex justify-content-between align-items-center bg-white">
                    <h5 class="mb-0">Proyek & Lomba</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Proyek kuliah atau lomba yang pernah diikuti</p>
                    <div class="mt-4">
                        @forelse ($user->projects ?? [] as $project)
                            <div class="mb-3 border-bottom pb-2">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="mb-0">{{ $project->nama_proyek }}</h6>
                                        @if ($project->deskripsi_proyek)
                                            <p class="mt-2 mb-1">{{ $project->deskripsi_proyek }}</p>
                                        @endif
                                        @if ($project->tautan)
                                            <a href="{{ $project->tautan }}" target="_blank" class="mt-2 mb-1 d-block text-primary text-decoration-underline">
                                                <i class="bi bi-box-arrow-up-right me-1"></i>{{ $project->tautan }}
                                            </a>
                                        @endif
                                        @if ($project->tanggal_pelaksanaan)
                                            <small class="text-muted">Tanggal Pelaksanaan: {{ $project->tanggal_pelaksanaan?->format('Y-m-d') }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <small class="text-muted">Belum ada proyek atau lomba yang ditambahkan.</small>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Pengalaman Kerja & Skills --}}
    <div class="row">
        <div class="col-md-6 mb-4">
            {{-- Section Pengalaman Kerja --}}
            <div class="card shadow h-100">
                <div class="card-header d-flex justify-content-between align-items-center bg-white">
                    <h5 class="mb-0">Pengalaman Kerja</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Pengalaman magang atau freelance</p>
                    <div class="mt-4">
                        @forelse ($user->workExperiences ?? [] as $experience)
                            <div class="mb-3 border-bottom pb-2">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="mb-0">{{ $experience->posisi }} di {{ $experience->nama_perusahaan }}</h6>
                                        <small class="text-muted">{{ $experience->lama_waktu }}</small>
                                        @if ($experience->deskripsi_kerja)
                                            <p class="mt-2 mb-1">{{ $experience->deskripsi_kerja }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <small class="text-muted">Belum ada pengalaman kerja yang ditambahkan.</small>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            {{-- Section Skills --}}
            <div class="card shadow h-100">
                <div class="card-header d-flex justify-content-between align-items-center bg-white">
                    <h5 class="mb-0">Skills</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Soft skills dan hard skills yang dimiliki</p>
                    <div class="mt-4">
                        @forelse ($user->skills ?? [] as $skill)
                            <div class="mb-3 border-bottom pb-2">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="mb-0">{{ $skill->nama_skill }}</h6>
                                        <small class="text-muted">{{ $skill->tipe }}</small>
                                        @if ($skill->deskripsi)
                                            <p class="mt-2 mb-1">{{ $skill->deskripsi }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <small class="text-muted">Belum ada skill yang ditambahkan.</small>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sertifikat & Penghargaan --}}
    <div class="row">
        <div class="col-md-6 mb-4">
            {{-- Section Sertifikat --}}
            <div class="card shadow h-100 w-100" style="border-radius: 0.75rem;">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Sertifikat</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Sertifikat yang telah diperoleh</p>
                    <div class="mt-4">
                        @forelse ($user->certificates ?? [] as $certificate)
                            <div class="mb-3 border-bottom pb-2 d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-0">{{ $certificate->nama_sertifikat }}</h6>
                                    <small class="text-muted">{{ $certificate->penyelenggara }} - {{ $certificate->tahun }}</small>
                                    @if ($certificate->deskripsi)
                                        <p class="mt-2 mb-1">{{ $certificate->deskripsi }}</p>
                                    @endif
                                    @if ($certificate->file_sertifikat)
                                        <a href="{{ $certificate->fileUrl }}" target="_blank" class="d-block mt-1 text-primary text-decoration-underline">Lihat Sertifikat</a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <small class="text-muted">Belum ada sertifikat yang ditambahkan.</small>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            {{-- Section Penghargaan --}}
            <div class="card shadow h-100 w-100" style="border-radius: 0.75rem;">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Penghargaan</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Penghargaan atau pencapaian yang diraih</p>
                    <div class="mt-4">
                        @forelse ($user->achievements ?? [] as $achievement)
                            <div class="mb-3 border-bottom pb-2 d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-0">{{ $achievement->nama_penghargaan }}</h6>
                                    <small class="text-muted">{{ $achievement->penyelenggara }} - {{ $achievement->tahun }}</small>
                                    @if ($achievement->deskripsi)
                                        <p class="mt-2 mb-1">{{ $achievement->deskripsi }}</p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <small class="text-muted">Belum ada penghargaan yang ditambahkan.</small>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tampilan Posting --}}
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4 w-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Postingan Mahasiswa</h5>
                </div>
                <div class="card-body">
                    @forelse ($posts as $post)
                        <div class="mb-4 border-bottom pb-3">
                            <div class="d-flex justify-content-between">
                                <strong>{{ $post->user->name }}</strong>
                                <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mt-2">{{ $post->caption }}</p>
                            {{-- Media --}}
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
                                        {{-- Modal Preview PDF --}}
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
                            {{-- Like & Comment --}}
                            @if(auth()->id() !== $user->id)
                        <div class="d-flex justify-content-between mt-2">
                            <form action="{{ route('posts.like', $post) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                    👍 Like ({{ $post->likes->count() }})
                                </button>
                            </form>

                            <a href="{{ route('posts.comments.show', $post) }}" class="btn btn-sm btn-outline-secondary">
                                💬 Komentar ({{ $post->comments->count() }})
                            </a>
                        </div>
                        @endif
                            <div class="d-flex justify-content-end gap-3">
                                <span>{{ $post->likes->count() }} Like</span>
                                <span>{{ $post->comments->count() }} Komentar</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">Belum ada postingan.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
