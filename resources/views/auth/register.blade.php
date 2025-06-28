@extends('layouts.app')

@section('title', 'Register - BangunKarir')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h4><i class="fas fa-user-plus me-2"></i>Daftar BangunKarir</h4>
                    <p class="mb-0">Bergabung dengan komunitas mahasiswa UISI</p>
                </div>
                <div class="card-body p-6">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
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

                    <!-- Google Register Button -->
                    <div class="d-grid mb-3">
                        <a href="{{ route('google.login') }}" class="btn btn-outline-danger">
                            <i class="fab fa-google me-2"></i>Daftar dengan Google
                        </a>
                    </div>

                    <div class="text-center mb-3">
                        <span class="text-muted">atau</span>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="{{ old('name') }}" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="{{ old('email') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation" 
                                   name="password_confirmation" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            <i class="fas fa-user-plus me-2"></i>Daftar
                        </button>
                    </form>

                    <div class="text-center">
                        <p>Sudah punya akun? <a href="{{ route('login') }}" class="text-primary">Masuk di sini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection