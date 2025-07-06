@extends('layouts.app')

@section('title', 'Edit Profil - BangunKarir')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4><i class="fas fa-user-edit me-2"></i>Edit Profil</h4>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Current Photo -->
                        @if($profile && ($profile->photo || Auth::user()->avatar))
                        <div class="mb-3 text-center">
                            @if($profile->photo)
                                <img src="{{ env('SUPABASE_PUBLIC') . $profile->photo }}" 
                                     alt="Foto Profil Saat Ini" class="profile-photo mb-2">
                            @else
                                <img src="{{ Auth::user()->avatar }}" 
                                     alt="Foto Profil Saat Ini" class="profile-photo mb-2">
                            @endif
                            <p class="text-muted">Foto profil saat ini</p>
                        </div>
                        @endif

                        <!-- Foto Profil -->
                        <div class="mb-4">
                            <label for="photo" class="form-label">Foto Profil Baru</label>
                            <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah foto</small>
                        </div>

                        <!-- Data Pribadi -->
                        <h5 class="text-primary mb-3">Data Pribadi</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nim" class="form-label">NIM</label>
                                <input type="text" class="form-control" id="nim" name="nim" 
                                       value="{{ old('nim', $profile->nim ?? '') }}" 
                                       {{ $profile->nim ? 'readonly' : 'required' }}>
                                @if($profile->nim)
                                    <small class="text-muted">NIM tidak dapat diubah</small>
                                @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="semester" class="form-label">Semester</label>
                                <select class="form-control" id="semester" name="semester" required>
                                    <option value="">Pilih Semester</option>
                                    @for($i = 1; $i <= 14; $i++)
                                        <option value="{{ $i }}" {{ old('semester', $profile->semester ?? '') == $i ? 'selected' : '' }}>
                                            Semester {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="prodi" class="form-label">Program Studi</label>
                            <select class="form-control" id="prodi" name="prodi" required>
                                <option value="">Pilih Program Studi</option>
                                @foreach($prodiOptions as $value => $label)
                                    <option value="{{ $value }}" {{ old('prodi', $profile->prodi ?? '') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Ringkasan Pribadi -->
                        <div class="mb-3">
                            <label for="ringkasan_pribadi" class="form-label">Ringkasan Pribadi</label>
                            <textarea class="form-control" id="ringkasan_pribadi" name="ringkasan_pribadi" 
                                      rows="4" placeholder="Ceritakan tentang diri Anda...">{{ old('ringkasan_pribadi', $profile->ringkasan_pribadi ?? '') }}</textarea>
                        </div>

                        <!-- Kontak -->
                        <div class="mb-3">
                            <label for="kontak_email" class="form-label">Email Kontak</label>
                            <input type="email" class="form-control" id="kontak_email" name="kontak_email" 
                                   value="{{ old('kontak_email', $profile->kontak_email ?? '') }}" required>
                        </div>

                        <!-- Riwayat Studi -->
                        <h5 class="text-primary mb-3">Riwayat Studi di UISI</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="riwayat_prodi" class="form-label">Program Studi</label>
                                <select class="form-control" id="riwayat_prodi" name="riwayat_prodi" required>
                                    <option value="">Pilih Program Studi</option>
                                    @foreach($prodiOptions as $value => $label)
                                        <option value="{{ $value }}" {{ old('riwayat_prodi', $profile->riwayat_prodi ?? '') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="tahun_masuk" class="form-label">Tahun Masuk</label>
                                <input type="number" class="form-control" id="tahun_masuk" name="tahun_masuk" 
                                       min="2000" max="{{ date('Y') }}" 
                                       value="{{ old('tahun_masuk', $profile->tahun_masuk ?? '') }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="ipk" class="form-label">IPK</label>
                                <input type="number" class="form-control" id="ipk" name="ipk" 
                                       step="0.01" min="0" max="4" 
                                       value="{{ old('ipk', $profile->ipk ?? '') }}" required>
                            </div>
                        </div>

                        <!-- Minat Karier -->
                        <h5 class="text-primary mb-3">Minat Karier</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="bidang_minat" class="form-label">Bidang Minat</label>
                                <input type="text" class="form-control" id="bidang_minat" name="bidang_minat" 
                                       value="{{ old('bidang_minat', $profile->bidang_minat ?? '') }}" 
                                       placeholder="Contoh: Software Development, Marketing, Finance" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="perusahaan_impian" class="form-label">Perusahaan Impian</label>
                                <input type="text" class="form-control" id="perusahaan_impian" name="perusahaan_impian" 
                                       value="{{ old('perusahaan_impian', $profile->perusahaan_impian ?? '') }}" 
                                       placeholder="Contoh: Google, Tokopedia, Bank BCA" required>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                            <a href="{{ route('profile.show') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection