 @extends('layouts.app')

@section('content')
<div class="container-fluid px-4">

    <div class="row">
        <!-- Profile Header -->
        <div class="col-12">
            <div class="card shadow mb-4 w-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center position-relative">
                        @if($profile && $profile->photo)
                            <img src="{{ asset('storage/' . $profile->photo) }}" alt="Profile Photo" class="rounded-circle img-fluid" style="width: 200px; height: 200px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto" style="width: 200px; height: 200px;">
                                <i class="bi bi-person" style="font-size: 4rem; color: #6c757d;"></i>
                            </div>
                        @endif

                        {{-- Tombol edit foto di kanan atas --}}
                        @if($profile)
                            <form action="{{ route('profile.update-photo') }}" method="POST" enctype="multipart/form-data" class="position-absolute" style="top: 20px; right: 50px;">
                                @csrf
                                <label for="photoInput" class="btn btn-sm btn-light border shadow rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; cursor: pointer;" title="Ganti Foto">
                                    <i class="bi bi-pencil"></i>
                                </label>
                                <input id="photoInput" type="file" name="photo" accept="image/*" onchange="this.form.submit()" style="display: none;">
                            </form>
                        @endif
                        </div>
                        
                        <div class="col-md-9">
                            <h2 class="mb-1">{{ $user->name }}</h2>
                            <p class="text-muted mb-2">{{ $profile->prodi ?? 'Program Studi belum diisi' }} - Semester {{ $profile->semester ?? 'N/A' }}</p>
                            <p class="mb-3">{{ $profile->ringkasan_pribadi ?? 'Belum ada ringkasan pribadi' }}</p>
                            
                            <!-- Progress Bar -->
                            <div class="mb-4">
                                <h6 class="mb-0">Kelengkapan Profil</h6>
                                @php
                                    // Hitung progress yang benar
                                    $basicProgress = $profile ? $profile->getProgressPercentage() : 0;
                                    
                                    // Progress profil lanjutan (40% dari total)
                                    $extensionSections = [
                                        'organizationalExperiences' => $user->organizationalExperiences ?? collect(),
                                        'projects' => $user->projects ?? collect(),
                                        'workExperiences' => $user->workExperiences ?? collect(),
                                        'skills' => $user->skills ?? collect(),
                                        'certificates' => $user->certificates ?? collect(),
                                        'achievements' => $user->achievements ?? collect(),
                                    ];
                                    
                                    $completedExtensions = 0;
                                    foreach($extensionSections as $section) {
                                        if($section->count() > 0) {
                                            $completedExtensions++;
                                        }
                                    }
                                    
                                    $extensionProgress = (count($extensionSections) > 0) ? ($completedExtensions / count($extensionSections)) * 100 : 0;
                                    
                                    // Total progress: 60% basic + 40% extension
                                    $totalProgress = ($basicProgress * 0.6) + ($extensionProgress * 0.4);
                                @endphp
                                <span class="badge bg-primary">{{ round($totalProgress) }}%</span>
                            </div>
                            <div class="w-100" style="max-width: 600px; padding-left: 0; padding-right: 0;">
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar" role="progressbar" style="width: {{ round($totalProgress) }}%"></div>
                            </div>
                            
                            <div class="mt-3">
                                @if($profile)
                                    <a href="{{ route('profile.edit') }}" class="btn btn-primary me-2">Edit Profil</a>
                                @else
                                    <a href="{{ route('profile.setup') }}" class="btn btn-primary">Lengkapi Profil Dasar</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Profile Details - PERBAIKAN LAYOUT -->
        <div class="row align-items-stretch">
    <div class="col-md-6 d-flex">
        <div class="card shadow mb-4 w-100">
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
                        <a href="{{ route('profile.setup') }}" class="btn btn-primary">Lengkapi Profil</a>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-6 d-flex">
        <div class="card shadow mb-4 w-100">
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
                        <a href="{{ route('profile.setup') }}" class="btn btn-primary">Lengkapi Profil</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
        <!-- Profile Extensions Preview -->
        @if($profile && $profile->is_complete)
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Profil Lanjutan</h5>
                            <a href="#profil-lanjutan" class="btn btn-sm btn-outline-primary">Kelola</a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="text-center">
                                        <i class="bi bi-building" style="font-size: 2rem; color: #0d6efd;"></i>
                                        <h6 class="mt-2">Pengalaman Organisasi</h6>
                                        <span class="badge bg-secondary">{{ ($user->organizationalExperiences ?? collect())->count() }} item</span>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="text-center">
                                        <i class="bi bi-code-square" style="font-size: 2rem; color: #198754;"></i>
                                        <h6 class="mt-2">Proyek</h6>
                                        <span class="badge bg-secondary">{{ ($user->projects ?? collect())->count() }} item</span>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="text-center">
                                        <i class="bi bi-briefcase" style="font-size: 2rem; color: #fd7e14;"></i>
                                        <h6 class="mt-2">Pengalaman Kerja</h6>
                                        <span class="badge bg-secondary">{{ ($user->workExperiences ?? collect())->count() }} item</span>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="text-center">
                                        <i class="bi bi-gear" style="font-size: 2rem; color: #6f42c1;"></i>
                                        <h6 class="mt-2">Skills</h6>
                                        <span class="badge bg-secondary">{{ ($user->skills ?? collect())->count() }} item</span>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="text-center">
                                        <i class="bi bi-award" style="font-size: 2rem; color: #dc3545;"></i>
                                        <h6 class="mt-2">Sertifikat</h6>
                                        <span class="badge bg-secondary">{{ ($user->certificates ?? collect())->count() }} item</span>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="text-center">
                                        <i class="bi bi-trophy" style="font-size: 2rem; color: #ffc107;"></i>
                                        <h6 class="mt-2">Penghargaan</h6>
                                        <span class="badge bg-secondary">{{ ($user->achievements ?? collect())->count() }} item</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div id="profil-lanjutan" class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Profil Lanjutan</h4>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Lengkapi profil Anda dengan informasi tambahan untuk meningkatkan peluang karir.</p>
                    </div>
                </div>
            </div>
        </div>
    
    <!-- Sections untuk mengisi profil lanjutan -->
    <div class="row">
        
        {{-- Section Pengalaman Organisasi --}}
    <div class="col-md-6 mb-4">
    <div class="card shadow h-100">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Pengalaman Organisasi</h5>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#organizationModal">
                <i class="bi bi-plus-circle me-1"></i> Tambah
            </button>
        </div>
        <div class="card-body">
            <p class="text-muted">Tambahkan pengalaman organisasi Anda</p>
            {{-- Daftar pengalaman organisasi --}}
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
                        <div class="ms-3 text-end">
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editOrgModal{{ $experience->id }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('organizational-experiences.destroy', $experience->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Modal Edit --}}
                    <div class="modal fade" id="editOrgModal{{ $experience->id }}" tabindex="-1" aria-labelledby="editOrgModalLabel{{ $experience->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('organizational-experiences.update', $experience->id) }}" method="POST" class="modal-content">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editOrgModalLabel{{ $experience->id }}">Edit Pengalaman Organisasi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Organisasi</label>
                                        <input type="text" name="nama_organisasi" class="form-control" value="{{ $experience->nama_organisasi }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Jabatan</label>
                                        <input type="text" name="jabatan" class="form-control" value="{{ $experience->jabatan }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Masuk</label>
                                        <input type="date" name="tanggal_masuk" class="form-control" value="{{ $experience->tanggal_masuk?->format('Y-m-d') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Selesai</label>
                                        <input type="date" name="tanggal_selesai" class="form-control" value="{{ $experience->tanggal_selesai?->format('Y-m-d') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Deskripsi Kegiatan</label>
                                        <textarea name="deskripsi_kegiatan" class="form-control" rows="3">{{ $experience->deskripsi_kegiatan }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <small class="text-muted">Belum ada pengalaman organisasi yang ditambahkan.</small>
                @endforelse
            </div>

            {{-- Notifikasi sukses --}}
            @if (session('success_organization'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    {{ session('success_organization') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            @endif

            <div class="mt-3">
                <small class="text-muted">{{ ($user->organizationalExperiences ?? collect())->count() }} item ditambahkan</small>
            </div>
        </div>
    </div>
    </div>
        {{-- Section Project --}}
    <div class="col-md-6 mb-4">
    <div class="card shadow h-100">
        <div class="card-header d-flex justify-content-between align-items-center bg-white">
            <h5 class="mb-0">Proyek & Lomba</h5>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#projectModal">
                <i class="bi bi-plus-circle me-1"></i> Tambah
            </button>
        </div>
        <div class="card-body">
            <p class="text-muted">Tambahkan proyek kuliah atau lomba yang pernah diikuti</p>

            {{-- Daftar Proyek --}}
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
                            <div class="d-flex align-items-start gap-1">
                                <!-- Tombol Edit -->
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editProjectModal{{ $project->id }}" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </button>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus proyek ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Edit Proyek --}}
                    <div class="modal fade" id="editProjectModal{{ $project->id }}" tabindex="-1" aria-labelledby="editProjectModalLabel{{ $project->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('projects.update', $project->id) }}" method="POST" class="modal-content">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editProjectModalLabel{{ $project->id }}">Edit Proyek & Lomba</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Proyek / Lomba</label>
                                        <input type="text" name="nama_proyek" class="form-control" value="{{ $project->nama_proyek }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Deskripsi</label>
                                        <textarea name="deskripsi_proyek" class="form-control" rows="3">{{ $project->deskripsi_proyek }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Pelaksanaan</label>
                                        <input type="date" name="tanggal_pelaksanaan" class="form-control" value="{{ $project->tanggal_pelaksanaan?->format('Y-m-d') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tautan</label>
                                        <input type="url" name="tautan" class="form-control" value="{{ $project->tautan }}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <small class="text-muted">Belum ada proyek atau lomba yang ditambahkan.</small>
                @endforelse
            </div>

            {{-- Notifikasi sukses --}}
            @if (session('success_project'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    {{ session('success_project') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            @endif

            <div class="mt-3">
                <small class="text-muted">{{ ($user->projects ?? collect())->count() }} item ditambahkan</small>
            </div>
        </div>
    </div>
    </div>

        
        <div class="col-md-6 mb-4">
    <div class="card shadow h-100">
        <div class="card-header d-flex justify-content-between align-items-center bg-white">
            <h5 class="mb-0">Pengalaman Kerja</h5>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#workModal">
                <i class="bi bi-plus-circle me-1"></i> Tambah
            </button>
        </div>
        <div class="card-body">
            <p class="text-muted">Tambahkan pengalaman magang atau freelance</p>

            {{-- Tampilkan data pengalaman kerja --}}
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
                            <div class="d-flex align-items-start gap-1">
                                <!-- Tombol Edit -->
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editWorkModal{{ $experience->id }}" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </button>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('work-experiences.destroy', $experience->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="editWorkModal{{ $experience->id }}" tabindex="-1" aria-labelledby="editWorkModalLabel{{ $experience->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('work-experiences.update', $experience->id) }}" method="POST" class="modal-content">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editWorkModalLabel{{ $experience->id }}">Edit Pengalaman Kerja</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Perusahaan</label>
                                        <input type="text" name="nama_perusahaan" class="form-control" value="{{ $experience->nama_perusahaan }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Posisi</label>
                                        <input type="text" name="posisi" class="form-control" value="{{ $experience->posisi }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Deskripsi Kerja</label>
                                        <textarea name="deskripsi_kerja" class="form-control" rows="3">{{ $experience->deskripsi_kerja }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Lama Waktu</label>
                                        <input type="text" name="lama_waktu" class="form-control" value="{{ $experience->lama_waktu }}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <small class="text-muted">Belum ada pengalaman kerja yang ditambahkan.</small>
                @endforelse
            </div>

            @if (session('success_work'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    {{ session('success_work') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="mt-3">
                <small class="text-muted">{{ ($user->workExperiences ?? collect())->count() }} item ditambahkan</small>
            </div>
        </div>
    </div>
    </div>

        
        <div class="col-md-6 mb-4">
    <div class="card shadow h-100">
        <div class="card-header d-flex justify-content-between align-items-center bg-white">
            <h5 class="mb-0">Skills</h5>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#skillModal">
                <i class="bi bi-plus-circle me-1"></i> Tambah
            </button>
        </div>
        <div class="card-body">
            <p class="text-muted">Tambahkan soft skills dan hard skills Anda</p>

            {{-- Daftar Skills --}}
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
                            <div class="d-flex align-items-start gap-1">
                                <!-- Tombol Edit -->
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editSkillModal{{ $skill->id }}" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </button>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('skills.destroy', $skill->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus skill ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Edit Skill --}}
                    <div class="modal fade" id="editSkillModal{{ $skill->id }}" tabindex="-1" aria-labelledby="editSkillModalLabel{{ $skill->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('skills.update', $skill->id) }}" method="POST" class="modal-content">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editSkillModalLabel{{ $skill->id }}">Edit Skill</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Skill</label>
                                        <input type="text" name="nama_skill" class="form-control" value="{{ $skill->nama_skill }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Deskripsi</label>
                                        <textarea name="deskripsi_skill" class="form-control" rows="3">{{ $skill->deskripsi_skill }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <small class="text-muted">Belum ada skill yang ditambahkan.</small>
                @endforelse
            </div>

            {{-- Notifikasi --}}
            @if (session('success_skill'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    {{ session('success_skill') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            @endif

            <div class="mt-3">
                <small class="text-muted">{{ ($user->skills ?? collect())->count() }} item ditambahkan</small>
            </div>
        </div>
    </div>
    </div>

        {{-- Section Sertifikat --}}
    <div class="col-md-6 mb-4">
        <div class="card shadow h-100 w-100" style="border-radius: 0.75rem;">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Sertifikat</h5>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#certificateModal">
                    <i class="bi bi-plus-circle me-1"></i> Tambah
                </button>
            </div>
            <div class="card-body">
                <p class="text-muted">Tambahkan sertifikat yang telah Anda peroleh</p>

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
                            <div class="ms-3 text-end">
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editCertificateModal{{ $certificate->id }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('profile.delete-certificate', $certificate->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus sertifikat ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Modal Edit Sertifikat --}}
                        <div class="modal fade" id="editCertificateModal{{ $certificate->id }}" tabindex="-1" aria-labelledby="editCertificateModalLabel{{ $certificate->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('profile.update-certificate', $certificate->id) }}" method="POST" class="modal-content" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Sertifikat</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Nama Sertifikat</label>
                                            <input type="text" name="nama_sertifikat" class="form-control" value="{{ $certificate->nama_sertifikat }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Penyelenggara</label>
                                            <input type="text" name="penyelenggara" class="form-control" value="{{ $certificate->penyelenggara }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Tahun</label>
                                            <input type="number" name="tahun" class="form-control" value="{{ $certificate->tahun }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Deskripsi</label>
                                            <textarea name="deskripsi" class="form-control" rows="3">{{ $certificate->deskripsi }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">File Sertifikat (PDF/JPG/PNG)</label>
                                            <input type="file" name="file_sertifikat" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    @empty
                        <small class="text-muted">Belum ada sertifikat yang ditambahkan.</small>
                    @endforelse
                </div>
                @if (session('success_certificate'))
                    <div class="alert alert-success mt-3">{{ session('success_certificate') }}</div>
                @endif
            </div>
        </div>
    </div>

    {{-- Section Penghargaan --}}
    <div class="col-md-6 mb-4">
        <div class="card shadow h-100 w-100" style="border-radius: 0.75rem;">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Penghargaan</h5>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#achievementModal">
                    <i class="bi bi-plus-circle me-1"></i> Tambah
                </button>
            </div>
            <div class="card-body">
                <p class="text-muted">Tambahkan penghargaan atau pencapaian yang Anda raih</p>

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
                            <div class="ms-3 text-end">
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editAchievementModal{{ $achievement->id }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('profile.delete-achievement', $achievement->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus penghargaan ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Modal Edit Penghargaan --}}
                        <div class="modal fade" id="editAchievementModal{{ $achievement->id }}" tabindex="-1" aria-labelledby="editAchievementModalLabel{{ $achievement->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('profile.update-achievement', $achievement->id) }}" method="POST" class="modal-content">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Penghargaan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Nama Penghargaan</label>
                                            <input type="text" name="nama_penghargaan" class="form-control" value="{{ $achievement->nama_penghargaan }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Penyelenggara</label>
                                            <input type="text" name="penyelenggara" class="form-control" value="{{ $achievement->penyelenggara }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Tahun</label>
                                            <input type="number" name="tahun" class="form-control" value="{{ $achievement->tahun }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Deskripsi</label>
                                            <textarea name="deskripsi" class="form-control" rows="3">{{ $achievement->deskripsi }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    @empty
                        <small class="text-muted">Belum ada penghargaan yang ditambahkan.</small>
                    @endforelse
                </div>
                @if (session('success_achievement'))
                    <div class="alert alert-success mt-3">{{ session('success_achievement') }}</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modals untuk form input akan ditambahkan di sini -->
    {{-- Pengalaman organisasi --}}
    <div class="modal fade" id="organizationModal" tabindex="-1" aria-labelledby="organizationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('organizational-experiences.store') }}" method="POST" class="modal-content">
        @csrf
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
        <div class="modal-header">
            <h5 class="modal-title" id="organizationModalLabel">Tambah Pengalaman Organisasi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
            <label for="namaOrganisasi" class="form-label">Nama Organisasi</label>
            <input type="text" name="nama_organisasi" id="namaOrganisasi" class="form-control" required>
            </div>
            <div class="mb-3">
            <label for="jabatan" class="form-label">Jabatan</label>
            <input type="text" name="jabatan" id="jabatan" class="form-control" required>
            </div>
            <div class="mb-3">
            <label for="tanggalMasuk" class="form-label">Tanggal Masuk</label>
            <input type="date" name="tanggal_masuk" id="tanggalMasuk" class="form-control" required>
            </div>
            <div class="mb-3">
            <label for="tanggalSelesai" class="form-label">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" id="tanggalSelesai" class="form-control">
            </div>
            <div class="mb-3">
            <label for="deskripsiKegiatan" class="form-label">Deskripsi Kegiatan</label>
            <textarea name="deskripsi_kegiatan" id="deskripsiKegiatan" rows="3" class="form-control" required></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        </form>
    </div>
    </div>


    {{-- Project --}}
    <div class="modal fade" id="projectModal" tabindex="-1" aria-labelledby="projectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('projects.store') }}" method="POST" class="modal-content">
        @csrf
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
        <div class="modal-header">
            <h5 class="modal-title" id="projectModalLabel">Tambah Proyek</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
            <label for="namaProyek" class="form-label">Nama Proyek</label>
            <input type="text" id="namaProyek" name="nama_proyek" class="form-control" required>
            </div>
            <div class="mb-3">
            <label for="deskripsiProyek" class="form-label">Deskripsi</label>
            <textarea id="deskripsiProyek" name="deskripsi_proyek" class="form-control" rows="3" required></textarea>
            </div>
            <div class="mb-3">
            <label for="tanggalPelaksanaan" class="form-label">Tanggal Pelaksanaan</label>
            <input type="date" id="tanggalPelaksanaan" name="tanggal_pelaksanaan" class="form-control" required>
            </div>
            <div class="mb-3"> 
            <label for="tautanProyek" class="form-label">Tautan</label>
            <input type="url" id="tautanProyek" name="tautan" class="form-control">
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        </form>
    </div>
    </div>

    {{-- Skill --}}
    <div class="modal fade" id="skillModal" tabindex="-1" aria-labelledby="skillModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('skills.store') }}" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="skillModalLabel">Tambah Keahlian</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
            <div class="mb-3">
                <label for="namaSkill" class="form-label">Keahlian</label>
                <input type="text" name="nama_skill" id="namaSkill" class="form-control" required>
                </div>
            <div class="mb-3">
                <label for="tipeSkill" class="form-label">Tipe</label>
                <select name="tipe" id="tipeSkill" class="form-select" required>
                    <option value="">Pilih Tipe</option>
                    <option value="Soft Skill">Soft Skill</option>
                    <option value="Hard Skill">Hard Skill</option>
                </select>
                </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi (Opsional)</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="2"></textarea>
            </div>
            </div>
            <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
        </form>
    </div>
    </div>

    {{-- Work Experience --}}
    <div class="modal fade" id="workModal" tabindex="-1" aria-labelledby="workModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('work-experiences.store') }}" method="POST" class="modal-content">
        @csrf
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
        <div class="modal-header">
            <h5 class="modal-title" id="workModalLabel">Tambah Pengalaman Kerja</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
            <label for="namaPerusahaan" class="form-label">Nama Perusahaan</label>
            <input type="text" id="namaPerusahaan" name="nama_perusahaan" class="form-control" required>
            </div>
            <div class="mb-3">
            <label for="posisiKerja" class="form-label">Posisi</label>
            <input type="text" id="posisiKerja" name="posisi" class="form-control" required>
            </div>
            <div class="mb-3">
            <label for="deskripsiKerja" class="form-label">Deskripsi Kerja</label>
            <textarea id="deskripsiKerja" name="deskripsi_kerja" class="form-control" rows="3" required></textarea>
            </div>
            <div class="mb-3">
            <label for="lamaWaktu" class="form-label">Lama Waktu</label>
            <input type="text" id="lamaWaktu" name="lama_waktu" class="form-control" placeholder="Contoh: 6 bulan" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        </form>
    </div>
    </div>

    {{-- Modal Tambah Sertifikat --}}
    <div class="modal fade" id="certificateModal" tabindex="-1" aria-labelledby="certificateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('profile.store-certificate') }}" method="POST" class="modal-content" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Sertifikat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Sertifikat</label>
                        <input type="text" name="nama_sertifikat" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Penyelenggara</label>
                        <input type="text" name="penyelenggara" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tahun</label>
                        <input type="number" name="tahun" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">File Sertifikat (PDF/JPG/PNG)</label>
                        <input type="file" name="file_sertifikat" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan Sertifikat</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Tambah Penghargaan --}}
    <div class="modal fade" id="achievementModal" tabindex="-1" aria-labelledby="achievementModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('profile.store-achievement') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Penghargaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Penghargaan</label>
                        <input type="text" name="nama_penghargaan" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Penyelenggara</label>
                        <input type="text" name="penyelenggara" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tahun</label>
                        <input type="number" name="tahun" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan Penghargaan</button>
                </div>
            </form>
        </div>
    </div>
    {{-- Tampilan posting --}}
    <div class="col-12">
    <div class="card shadow mb-4 w-100">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Postingan Mahasiswa</h5>
            <a href="{{ route('posts.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Buat Postingan
            </a>
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
                                <img src="{{ asset('storage/' . $post->media_path) }}" class="img-fluid rounded">
                            
                            @elseif ($post->media_type === 'video')
                                <video controls class="w-100 rounded">
                                    <source src="{{ asset('storage/' . $post->media_path) }}">
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
                                                <iframe src="{{ asset('storage/' . $post->media_path) }}" width="100%" height="100%" style="border: none;"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Like & Comment --}}
                    <div class="d-flex justify-content-end gap-3">
                        <span>{{ $post->likes->count() }} Like</span>
                        <span>{{ $post->comments->count() }} Komentar</span>
                    </div>

                    {{-- Tombol Aksi --}}
                    @if(auth()->id() === $post->user_id)
                        <div class="mt-2">
                            <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus postingan?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @empty
                <p class="text-muted">Belum ada postingan.</p>
            @endforelse
        </div>
    </div>

    @endsection