@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Profil Lanjutan</h4>
                    <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary">Kembali ke Profil</a>
                </div>
                <div class="card-body">
                    <p class="text-muted">Lengkapi profil Anda dengan informasi tambahan untuk meningkatkan peluang karir.</p>
                    
                    <!-- Progress Profil Lanjutan -->
                    @php
                        $extensionSections = [
                            'organizationalExperiences' => $user->organizationalExperiences ?? collect(),
                            'projects' => $user->projects ?? collect(),
                            'workExperiences' => $user->workExperiences ?? collect(),
                            'skills' => $user->skills ?? collect(),
                            'certificates' => $user->certificates ?? collect(),
                            'achievements' => $user->achievements ?? collect(),
                            'portfolios' => $user->portfolios ?? collect(),
                        ];
                        
                        $completedExtensions = 0;
                        foreach($extensionSections as $section) {
                            if($section->count() > 0) {
                                $completedExtensions++;
                            }
                        }
                        
                        $extensionProgress = (count($extensionSections) > 0) ? ($completedExtensions / count($extensionSections)) * 100 : 0;
                    @endphp
                    
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Progress Profil Lanjutan</span>
                            <span class="badge bg-primary">{{ round($extensionProgress) }}%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar" role="progressbar" style="width: {{ round($extensionProgress) }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sections untuk mengisi profil lanjutan -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Pengalaman Organisasi</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Tambahkan pengalaman organisasi Anda</p>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#organizationModal">
                        Tambah Pengalaman
                    </button>
                    <div class="mt-3">
                        <small class="text-muted">{{ ($user->organizationalExperiences ?? collect())->count() }} item ditambahkan</small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Proyek & Lomba</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Tambahkan proyek kuliah atau lomba yang pernah diikuti</p>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#projectModal">
                        Tambah Proyek
                    </button>
                    <div class="mt-3">
                        <small class="text-muted">{{ ($user->projects ?? collect())->count() }} item ditambahkan</small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Pengalaman Kerja</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Tambahkan pengalaman magang atau freelance</p>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#workModal">
                        Tambah Pengalaman
                    </button>
                    <div class="mt-3">
                        <small class="text-muted">{{ ($user->workExperiences ?? collect())->count() }} item ditambahkan</small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Skills</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Tambahkan soft skills dan hard skills Anda</p>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#skillModal">
                        Tambah Skills
                    </button>
                    <div class="mt-3">
                        <small class="text-muted">{{ ($user->skills ?? collect())->count() }} item ditambahkan</small>
                    </div>
                </div>
            </div>
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
                <option value="soft_skill">Soft Skill</option>
                <option value="hard_skill">Hard Skill</option>
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

{{-- Postingan --}}
<div class="container mt-5">
    <h2>{{ $user->name }}</h2>
    <h4 class="mb-3">Postingan:</h4>

    @forelse ($posts as $post)
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <strong>{{ $post->user->name }}</strong>
                    <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                </div>
                <p class="mt-2">{{ $post->caption }}</p>

                @if ($post->media_path)
                    @php
                        $mediaUrl = env('SUPABASE_PUBLIC') . $post->media_path;
                    @endphp
                    <div class="mt-2">
                        @if ($post->media_type === 'image')
                            <img src="{{ $mediaUrl }}" class="img-fluid rounded" width="300">
                        @elseif ($post->media_type === 'video')
                            <video controls width="300" class="rounded">
                                <source src="{{ $mediaUrl }}">
                            </video>
                        @elseif ($post->media_type === 'pdf')
                            <a href="{{ $mediaUrl }}" target="_blank" class="btn btn-outline-primary btn-sm">📄 Lihat Dokumen</a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @empty
        <p class="text-muted">Belum ada postingan.</p>
    @endforelse
</div>

@endsection 
