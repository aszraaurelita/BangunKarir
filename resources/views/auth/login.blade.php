@extends('layouts.app')

@section('title', 'Login - BangunKarir')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h4><i class="fas fa-briefcase me-2"></i>BangunKarir UISI</h4>
                    <p class="mb-0">Masuk ke akun Anda</p>
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

                    <!-- Google Login Button -->
                    <div class="d-grid mb-3">
                        <a href="{{ route('google.login') }}" class="btn btn-outline-danger">
                            <i class="fab fa-google me-2"></i>Masuk dengan Google
                        </a>
                    </div>

                    <div class="text-center mb-3">
                        <span class="text-muted">atau</span>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="{{ old('email') }}" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Ingat saya</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            <i class="fas fa-sign-in-alt me-2"></i>Masuk
                        </button>
                    </form>

                    <div class="text-center">
                        <p>Belum punya akun? <a href="{{ route('register') }}" class="text-primary">Daftar di sini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection