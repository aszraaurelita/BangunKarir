@extends('layouts.app')

@section('title', 'Setup Profil - BangunKarir')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4><i class="fas fa-user-edit me-2"></i>Lengkapi Profil Anda</h4>
                    <p class="mb-0">Isi informasi profil untuk melanjutkan</p>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h6>Terjadi kesalahan:</h6>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.store') }}" enctype="multipart/form-data" id="profileForm">
                        @csrf
                        
                        <!-- Debug Info -->
                        <div class="alert alert-info">
                            <small>
                                <strong>Debug Info:</strong><br>
                                User ID: {{ Auth::id() }}<br>
                                Has Profile: {{ Auth::user()->profile ? 'Yes' : 'No' }}<br>
                                @if(Auth::user()->profile)
                                    Profile Complete: {{ Auth::user()->profile->is_complete ? 'Yes' : 'No' }}<br>
                                    Profile ID: {{ Auth::user()->profile->id }}
                                @endif
                            </small>
                        </div>
                        
                        <!-- Foto Profil -->
                        <div class="mb-4">
                            <label for="photo" class="form-label">Foto Profil</label>
                            @if($profile && $profile->photo)
                                <div class="mb-2">
                                    <img src="{{ env('SUPABASE_PUBLIC') . $profile->photo }}" 
                                         alt="Foto Profil Saat Ini" class="profile-photo" style="width: 100px; height: 100px;">
                                    <p class="text-muted mt-1">Foto profil saat ini</p>
                                </div>
                            @endif
                            <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB.</small>
                        </div>

                        <!-- Data Pribadi -->
                        <h5 class="text-primary mb-3">Data Pribadi</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nim" class="form-label">NIM <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nim') is-invalid @enderror" 
                                       id="nim" name="nim" 
                                       value="{{ old('nim', $profile->nim ?? '') }}" 
                                       {{ ($profile && $profile->nim) ? 'readonly' : 'required' }}>
                                @error('nim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($profile && $profile->nim)
                                    <small class="text-muted">NIM tidak dapat diubah setelah disimpan</small>
                                @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                                <select class="form-control @error('semester') is-invalid @enderror" 
                                        id="semester" name="semester" required>
                                    <option value="">Pilih Semester</option>
                                    @for($i = 1; $i <= 14; $i++)
                                        <option value="{{ $i }}" {{ old('semester', $profile->semester ?? '') == $i ? 'selected' : '' }}>
                                            Semester {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                                @error('semester')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="prodi" class="form-label">Program Studi <span class="text-danger">*</span></label>
                            <select class="form-control @error('prodi') is-invalid @enderror" 
                                    id="prodi" name="prodi" required>
                                <option value="">Pilih Program Studi</option>
                                @foreach($prodiOptions as $value => $label)
                                    <option value="{{ $value }}" {{ old('prodi', $profile->prodi ?? '') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('prodi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Ringkasan Pribadi -->
                        <div class="mb-3">
                            <label for="ringkasan_pribadi" class="form-label">Ringkasan Pribadi</label>
                            <textarea class="form-control @error('ringkasan_pribadi') is-invalid @enderror" 
                                      id="ringkasan_pribadi" name="ringkasan_pribadi" 
                                      rows="4" placeholder="Ceritakan tentang diri Anda...">{{ old('ringkasan_pribadi', $profile->ringkasan_pribadi ?? '') }}</textarea>
                            @error('ringkasan_pribadi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kontak -->
                        <div class="mb-3">
                            <label for="kontak_email" class="form-label">Email Kontak <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('kontak_email') is-invalid @enderror" 
                                   id="kontak_email" name="kontak_email" 
                                   value="{{ old('kontak_email', $profile->kontak_email ?? Auth::user()->email) }}" required>
                            @error('kontak_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Riwayat Studi -->
                        <h5 class="text-primary mb-3">Riwayat Studi di UISI</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="riwayat_prodi" class="form-label">Program Studi <span class="text-danger">*</span></label>
                                <select class="form-control @error('riwayat_prodi') is-invalid @enderror" 
                                        id="riwayat_prodi" name="riwayat_prodi" required>
                                    <option value="">Pilih Program Studi</option>
                                    @foreach($prodiOptions as $value => $label)
                                        <option value="{{ $value }}" {{ old('riwayat_prodi', $profile->riwayat_prodi ?? '') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('riwayat_prodi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="tahun_masuk" class="form-label">Tahun Masuk <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('tahun_masuk') is-invalid @enderror" 
                                       id="tahun_masuk" name="tahun_masuk" 
                                       min="2000" max="{{ date('Y') }}" 
                                       value="{{ old('tahun_masuk', $profile->tahun_masuk ?? '') }}" required>
                                @error('tahun_masuk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="ipk" class="form-label">IPK <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('ipk') is-invalid @enderror" 
                                       id="ipk" name="ipk" 
                                       step="0.01" min="0" max="4" 
                                       value="{{ old('ipk', $profile->ipk ?? '') }}" required>
                                @error('ipk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Minat Karier -->
                        <h5 class="text-primary mb-3">Minat Karier</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="bidang_minat" class="form-label">Bidang Minat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('bidang_minat') is-invalid @enderror" 
                                       id="bidang_minat" name="bidang_minat" 
                                       value="{{ old('bidang_minat', $profile->bidang_minat ?? '') }}" 
                                       placeholder="Contoh: Software Development, Marketing, Finance" required>
                                @error('bidang_minat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="perusahaan_impian" class="form-label">Perusahaan Impian <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('perusahaan_impian') is-invalid @enderror" 
                                       id="perusahaan_impian" name="perusahaan_impian" 
                                       value="{{ old('perusahaan_impian', $profile->perusahaan_impian ?? '') }}" 
                                       placeholder="Contoh: Google, Tokopedia, Bank BCA" required>
                                @error('perusahaan_impian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100" id="submitBtn">
                            <i class="fas fa-save me-2"></i>Simpan Profil
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('profileForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
});
</script>
@endsection