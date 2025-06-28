@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h4 class="mb-4">Beranda</h4>
    
    {{-- Pencarian --}}
    <form action="{{ route('users.search') }}" method="GET" class="mb-4">
    <div class="row g-2">
        <div class="col-md-3">
            <input type="text" name="nama" class="form-control" placeholder="Cari Nama" value="{{ request('nama') }}">
        </div>
        <div class="col-md-3">
            <select name="prodi" id="prodiSelect" class="form-select">
                <option value="">Pilih Prodi</option>
                @foreach(array_keys($minatKarierMap) as $prodi)
                    <option value="{{ $prodi }}" {{ request('prodi') == $prodi ? 'selected' : '' }}>{{ $prodi }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <select name="interest" id="minatSelect" class="form-select">
                <option value="">Pilih Minat Karier</option>
                {{-- Akan diisi via JavaScript --}}
            </select>
            <small class="text-muted mt-1">* Pilih program studi untuk pilihan minat karier.</small>
        </div>

        <div class="col-md-3">
            <select name="skill" class="form-select">
                <option value="">Pilih Keahlian</option>
                @foreach($allSkills as $skill)
                    <option value="{{ $skill->id }}" {{ request('skill') == $skill->id ? 'selected' : '' }}>
                        {{ $skill->nama_skill }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary w-100">Cari</button>
        </div>
    </div>
    </form>

    {{-- Tampilkan hasil pencarian --}}
    @if(request()->hasAny(['nama', 'prodi', 'interest', 'skill']))
        <div class="mb-4">
            <h5>Hasil Pencarian</h5>
            <div class="row">
                @forelse($users as $user)
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5>{{ $user->name }}</h5>
                            <p class="mb-1"><strong>Prodi:</strong> {{ $user->profile->prodi ?? '-' }}</p>
                            <p class="mb-1"><strong>Semester:</strong> {{ $user->profile->semester ?? '-' }}</p>
                            <p class="mb-1"><strong>Minat:</strong> {{ $user->profile->bidang_minat ?? '-' }}</p>
                            <p class="mb-1"><strong>Keahlian:</strong></p>
                            <ul class="mb-0">
                                @forelse($user->skills as $skill)
                                    <li>{{ $skill->nama_skill }}</li>
                                @empty
                                    <li class="text-muted">Belum ada keahlian</li>
                                @endforelse
                            </ul>
                            <div class="text-center">
                                <a href="{{ route('users.profile', ['id' => $user->id]) }}" class="btn btn-sm btn-outline-primary">
                                    👤 Lihat Profil
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning text-center">Mahasiswa tidak ditemukan.</div>
                    </div>
                @endforelse
            </div>
        </div>
    @endif

    {{-- Rekomendasi Akun --}}
    @if($recommendedUsers->isNotEmpty())
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="mb-3">Rekomendasi Akun</h5>
                <div class="d-flex overflow-auto gap-3">
                    @foreach ($recommendedUsers as $user)
                        <div class="card text-center p-2" style="width: 140px; flex: 0 0 auto;">
                            @php
                                $userId = $user->id ?? null;
                            @endphp

                            <div class="d-flex justify-content-center mb-2">
                                @if ($user->profile?->photo)
                                    <img src="{{ asset('storage/' . $user->profile->photo) }}" 
                                        class="rounded-circle" 
                                        width="60" height="60" 
                                        style="object-fit: cover; aspect-ratio: 1/1;">
                                @else
,                                           <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                         style="width:60px; height:60px;">
                                        <i class="bi bi-person-circle fs-1 text-secondary"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="small fw-bold">{{ Str::limit($user->name, 12) }}</div>
                            <div class="text-muted small mb-2">{{ $user->profile->prodi ?? '-' }}</div>

                            @if ($userId)
                                <a href="{{ route('users.profile', ['id' => $userId]) }}" class="btn btn-sm btn-outline-primary">Lihat</a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
{{-- POSTINGAN --}}
    <div id="postingan">
        @forelse ($posts as $post)
            <div id="post-{{ $post->id }}" class="card mb-4">
                <div class="card-body">
                    
                    {{-- Header: Foto Profil & Nama --}}
                    <div class="d-flex align-items-center mb-2">
                        <div class="me-2 rounded-circle overflow-hidden d-flex justify-content-center align-items-center" style="width: 48px; height: 48px; background-color: #e9ecef;">
                            @if ($post->user->profile?->photo)
                                <img src="{{ asset('storage/' . $post->user->profile->photo) }}" alt="Foto Profil" class="w-100 h-100" style="object-fit: cover;">
                            @else
                                <i class="bi bi-person-circle text-secondary" style="font-size: 24px;"></i>
                            @endif
                        </div>
                        {{-- Nama Pengguna --}}
                        <div>
                            <strong>{{ $post->user->name }}</strong><br>
                            <small class="text-muted">{{ $post->user->profile->prodi ?? '-' }} | Semester {{ $post->user->profile->semester ?? '-' }}</small>
                        </div>
                        <small class="ms-auto text-muted">{{ $post->created_at->diffForHumans() }}</small>
                    </div>

                    {{-- Caption --}}
                    <p>{{ $post->caption }}</p>

                    {{-- Media --}}
                    @if ($post->media_path)
                        <div class="mt-3">
                            @if ($post->media_type === 'image')
                            <img src="{{ asset('storage/' . $post->media_path) }}"
                                class="img-fluid rounded d-block mx-auto"
                                style="max-width: 300px;"
                                onerror="this.onerror=null;this.src='{{ asset('images/placeholder.png') }}';"
                                alt="Post Image">
                            
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

                    {{-- Like & Komentar --}}
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

                    {{-- Form Kirim Komentar --}}
                    <form action="{{ route('posts.comment', $post) }}" method="POST" class="mt-3">
                        @csrf
                        <div class="input-group input-group-sm">
                            <input type="text" name="content" class="form-control" placeholder="Tulis komentar..." required>
                            <button class="btn btn-outline-primary" type="submit">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-muted">Belum ada postingan yang tersedia.</p>
        @endforelse
    </div>
    
    {{-- Highlight dan scroll ke postingan tertentu --}}
    @isset($highlight)
        <script>
            window.onload = function () {
                const target = document.getElementById('post-{{ $highlight }}');
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    target.style.backgroundColor = '#fff3cd';
                    setTimeout(() => target.style.backgroundColor = '', 2000);
                }
            };
        </script>
    @endisset
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const minatKarierMap = @json($minatKarierMap);
        const prodiSelect = document.getElementById('prodiSelect');
        const minatSelect = document.getElementById('minatSelect');
        const selectedMinat = "{{ request('interest') }}";

        function populateMinatKarier(prodi) {
            minatSelect.innerHTML = '<option value="">-- Pilih Minat Karier --</option>';
            if (minatKarierMap[prodi]) {
                minatKarierMap[prodi].forEach(function (minat) {
                    const option = document.createElement('option');
                    option.value = minat;
                    option.textContent = minat;
                    if (minat === selectedMinat) {
                        option.selected = true;
                    }
                    minatSelect.appendChild(option);
                });
            }
        }

        // Load saat halaman dimuat
        if (prodiSelect.value !== "") {
            populateMinatKarier(prodiSelect.value);
        }

        // Ganti saat prodi dipilih
        prodiSelect.addEventListener('change', function () {
            populateMinatKarier(this.value);
        });
    });
</script>
@endpush

@endsection