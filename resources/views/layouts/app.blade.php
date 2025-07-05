<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BangunKarir - UISI')</title>
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-orange: #FF6B35;
            --primary-red: #DC3545;
            --light-orange: #FFE5D9;
            --dark-orange: #E55A2B;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar-brand {
            font-weight: bold;
            color: #f8f9fa !important;
        }
        
        .btn-primary {
            background-color: var(--primary-orange);
            border-color: var(--primary-orange);
        }
        
        .btn-primary:hover {
            background-color: var(--dark-orange);
            border-color: var(--dark-orange);
        }
        
        .btn-danger {
            background-color: var(--primary-red);
            border-color: var(--primary-red);
        }
        
        .text-primary {
            color: var(--primary-orange) !important;
        }
        
        .bg-primary {
            background-color: var(--primary-orange) !important;
        }
        
        .card {
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        
        .profile-photo {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid var(--primary-orange);
        }
        
        .progress-bar {
            background-color: var(--primary-orange);
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--primary-orange), var(--primary-red));
        }
        
        .form-control:focus {
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25);
        }
    </style>
</head>
<body>
   {{-- layouts/app.blade.php --}}
        @php
        $isLanding = Request::is('/');
        $isLoginOrRegister = Request::routeIs('login') || Request::routeIs('register');
        $isBeranda = Request::routeIs('beranda');
        $isProfil = Request::routeIs('profile.show');
    @endphp

    <nav class="navbar navbar-expand-lg navbar-dark {{ $isLanding ? 'bg-dark' : '' }}" style="background: linear-gradient(135deg, var(--primary-orange), var(--primary-red));">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-briefcase me-2"></i>BangunKarir
            </a>

            {{-- Landing Page --}}
            @if ($isLanding)
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
                        <li class="nav-item"><a class="nav-link" href="#fitur">Fitur</a></li>
                        <li class="nav-item"><a class="nav-link" href="#testimoni">Testimoni</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Masuk</a></li>
                        <li class="nav-item"><a class="nav-link btn btn-light text-dark ms-2" href="{{ route('register') }}">Daftar</a></li>
                    </ul>
                </div>

            {{-- Login & Register --}}
            @elseif ($isLoginOrRegister)
                {{-- Hanya Logo Saja --}}

            {{-- Halaman Beranda --}}
            @elseif ($isBeranda)
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('beranda') }}"><i class="bi bi-house me-1"></i>Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#postingan"><i class="bi bi-chat-dots me-1"></i>Postingan</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">{{ Auth::user()->name }}</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('profile.show') }}">Profil Saya</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>

            {{-- Halaman Profil --}}
            @elseif ($isProfil)
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('beranda') }}"><i class="bi bi-house me-1"></i>Beranda</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">{{ Auth::user()->name }}</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Edit Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            @endif
        </div>
    </nav>


    <main class="py-4">
        @yield('content')
    </main>
    @yield('scripts')
    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>