<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BangunKarir - UISI')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

        a {
            text-decoration: none !important;
        }

        a:hover,
        a:focus {
            text-decoration: none !important;
        }

        a:active {
            text-decoration: underline !important; /* kalau mau muncul saat diklik, kalau gak mau ya hapus aja */
        }
    </style>
</head>
<body>
<div class="min-h-screen bg-white">
    {{-- Navigation --}}
    <nav class="fixed top-0 w-full bg-white border-b border-gray-200 z-50">
        <div class="container-fluid px-6 py-4 flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-gradient-to-r from-orange-500 to-red-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-briefcase text-white text-sm"></i>
                </div>
                <span class="text-xl font-bold text-gray-900">BangunKarir</span>
                <span class="ml-2 px-2 py-1 bg-orange-100 text-orange-700 text-xs rounded-full font-medium">UISI</span>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="#tentang" class="text-gray-600 hover:text-red-600 font-medium">Tentang</a>
                <a href="#fitur" class="text-gray-600 hover:text-red-600 font-medium">Fitur</a>
                <a href="#testimoni" class="text-gray-600 hover:text-red-600 font-medium">Testimoni</a>
                <a href="{{ route('login') }}" class="text-red-600 hover:text-red-700 font-medium">Masuk</a>
                <a href="{{ route('register') }}" class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-4 py-2 rounded-lg font-medium transition-all">
                    Daftar Gratis
                </a>
            </div>

            <!-- Hamburger Button (mobile only) -->
            <div class="md:hidden">
                <button id="menu-toggle" class="focus:outline-none">
                    <i class="fas fa-bars text-gray-600 text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden px-4 pb-4">
            <div class="flex flex-col space-y-4 pt-4 border-t border-gray-200">
                <a href="#tentang" class="text-gray-600 hover:text-red-600 font-medium">Tentang</a>
                <a href="#fitur" class="text-gray-600 hover:text-red-600 font-medium">Fitur</a>
                <a href="#testimoni" class="text-gray-600 hover:text-red-600 font-medium">Testimoni</a>
                <a href="{{ route('login') }}" class="text-red-600 hover:text-red-700 font-medium">Masuk</a>
                <a href="{{ route('register') }}" class="bg-gradient-to-r from-red-500 to-red-600 text-white px-4 py-2 rounded-lg font-medium text-center">Daftar Gratis</a>
            </div>
        </div>
    </nav>


    {{-- Hero Section --}}
    <section class="pt-24 pb-20 bg-gradient-to-br from-orange-50 via-white to-red-50">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto text-center">
                <div class="space-y-8">
                    <div class="space-y-6">
                        <span class="inline-flex items-center px-4 py-2 bg-orange-100 text-orange-700 text-sm font-semibold rounded-full">
                            🎓 Platform Eksklusif Mahasiswa UISI
                        </span>
                        <h1 class="text-5xl lg:text-7xl font-bold text-gray-900 leading-tight">
                            Wujudkan Impian
                            <span class="bg-gradient-to-r from-orange-500 to-red-500 bg-clip-text text-transparent">
                                Karier Cemerlang
                            </span>
                            Sejak Hari Ini!
                        </h1>
                        <p class="text-xl lg:text-2xl text-gray-600 leading-relaxed max-w-3xl mx-auto">
                            Jadilah bagian dari revolusi karier mahasiswa UISI! Bangun personal branding yang memukau, 
                            tampilkan prestasi terbaikmu, dan raih peluang karier impian. Masa depan cemerlangmu dimulai dari sini!
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white text-xl px-6 py-3 rounded-lg font-bold transition-all transform hover:scale-105 shadow-lg">
                            🚀 Mulai Perjalanan Suksesmu
                            <i class="fas fa-arrow-right ml-3"></i>
                        </a>
                        <a href="#fitur" class="inline-flex items-center justify-center bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white text-xl px-6 py-3 rounded-lg font-bold transition-all transform hover:scale-105 shadow-lg">
                            <i class="fas fa-play mr-3"></i>
                            Jelajahi Fitur Keren
                        </a>
                    </div>

                    <div class="flex items-center justify-center space-x-12 pt-8">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-orange-600">500+</div>
                            <div class="text-sm text-gray-600 font-medium">Mahasiswa Bergabung</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-red-600">50+</div>
                            <div class="text-sm text-gray-600 font-medium">Perusahaan Partner</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-orange-600">100+</div>
                            <div class="text-sm text-gray-600 font-medium">Peluang Karier</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- About Section --}}
    <section id="tentang" class="py-20 scroll-mt-20" style="background-color: #FFE5D9;">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">Tentang BangunKarir</h2>
                <p class="text-xl text-gray-600 max-w-4xl mx-auto">
                    BangunKarir adalah platform inovatif yang dirancang khusus untuk mahasiswa UISI. Kami berkomitmen untuk membantu mahasiswa dalam membangun personal branding yang kuat, mengakses peluang karier yang relevan, dan terhubung dengan perusahaan-perusahaan terkemuka. Dengan fitur-fitur canggih dan dukungan dari mentor berpengalaman, kami siap membantu mahasiswa mencapai impian karier mereka.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 max-w-6xl mx-auto px-6">
                <!-- Card Visi -->
                <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 p-8 text-left border-2 border-orange-100 hover:border-orange-300">
                    <div class="w-20 h-20 bg-gradient-to-r from-orange-400 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-eye text-3xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Visi</h3>
                    <p class="text-gray-700">
                        Menjadi platform terpercaya dalam membentuk generasi profesional yang siap bersaing di dunia kerja melalui pengembangan diri dan koneksi industri.
                    </p>
                </div>

                <!-- Card Misi -->
                <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 p-8 text-left border-2 border-orange-100 hover:border-orange-300">
                    <div class="w-20 h-20 bg-gradient-to-r from-red-400 to-red-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-bullseye text-3xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Misi</h3>
                    <p class="text-gray-600 mb-6">
                        Kami memiliki misi untuk membentuk mahasiswa yang siap berdaya saing tinggi melalui:
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-start text-gray-600">
                            <i class="fas fa-check-circle text-orange-500 mr-3 mt-1"></i>
                            Membangun personal branding yang kuat dan berkesan
                        </li>
                        <li class="flex items-start text-gray-600">
                            <i class="fas fa-check-circle text-orange-500 mr-3 mt-1"></i>
                            Menyediakan akses magang dan kerja sama dengan perusahaan terpercaya
                        </li>
                        <li class="flex items-start text-gray-600">
                            <i class="fas fa-check-circle text-orange-500 mr-3 mt-1"></i>
                            Memberikan bimbingan dari mentor berpengalaman
                        </li>
                        <li class="flex items-start text-gray-600">
                            <i class="fas fa-check-circle text-orange-500 mr-3 mt-1"></i>
                            Membuka ruang eksplorasi karier sesuai minat dan potensi
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>


    {{-- Why Choose Us --}}
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">Kenapa BangunKarir Pilihan Terbaik?</h2>
                <p class="text-xl text-gray-600 max-w-4xl mx-auto">
                    Platform revolusioner yang dirancang khusus untuk mengangkat potensi mahasiswa UISI ke level profesional tertinggi
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 p-8 text-center border-2 border-orange-100 hover:border-orange-300">
                    <div class="w-20 h-20 bg-gradient-to-r from-orange-400 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-crown text-3xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Diakses oleh HRD</h3>
                    <p class="text-gray-600">
                        Akses langsung ke HRD dari berbagai perusahaan terkemuka yang mencari talenta terbaik.
                    </p>
                </div>

                <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 p-8 text-center border-2 border-red-100 hover:border-red-300">
                    <div class="w-20 h-20 bg-gradient-to-r from-red-400 to-red-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-rocket text-3xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Personal Branding</h3>
                    <p class="text-gray-600">
                        Bangun reputasi profesional yang memukau dan jadilah magnet bagi perusahaan top
                    </p>
                </div>

                <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 p-8 text-center border-2 border-orange-100 hover:border-orange-300">
                    <div class="w-20 h-20 bg-gradient-to-r from-orange-400 to-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-trophy text-3xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Peluang Emas</h3>
                    <p class="text-gray-600">
                        Akses langsung ke recruiter top dan peluang magang/kerja di perusahaan impian
                    </p>
                </div>

                <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 p-8 text-center border-2 border-red-100 hover:border-red-300">
                    <div class="w-20 h-20 bg-gradient-to-r from-red-400 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-users text-3xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Networking Premium</h3>
                    <p class="text-gray-600">
                        Terhubung dengan alumni sukses, mentor berpengalaman, dan leader industri
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Features --}}
    <section id="fitur" class="py-20 bg-gradient-to-br from-orange-50 to-red-50 scroll-mt-20">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">Fitur Super Lengkap untuk Kesuksesan Total</h2>
                <p class="text-xl text-gray-600 max-w-4xl mx-auto">
                    Semua yang kamu butuhkan untuk menjadi mahasiswa paling dicari di industri
                </p>
            </div>

            <div class="grid lg:grid-cols-2 gap-8 max-w-6xl mx-auto">
                <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-orange-100">
                    <div class="w-16 h-16 bg-gradient-to-r from-orange-400 to-orange-600 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-user-tie text-2xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Profil Profesional</h3>
                    <p class="text-gray-600 mb-6">
                        Ciptakan profil yang memukau dengan showcase lengkap prestasi, proyek, dan keahlianmu
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-center text-gray-600">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            Portfolio digital yang menawan
                        </li>
                        <li class="flex items-center text-gray-600">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            Riwayat prestasi akademik
                        </li>
                        <li class="flex items-center text-gray-600">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            Showcase proyek terbaik
                        </li>
                    </ul>
                </div>

                <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-red-100">
                    <div class="w-16 h-16 bg-gradient-to-r from-red-400 to-red-600 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-share-alt text-2xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Konten & Berbagi</h3>
                    <p class="text-gray-600 mb-6">
                        Bagikan pencapaian luar biasa dan bangun personal branding yang tak terlupakan
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-center text-gray-600">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            Posting multimedia menarik
                        </li>
                        <li class="flex items-center text-gray-600">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            Story pencapaian inspiratif
                        </li>
                        <li class="flex items-center text-gray-600">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            Interaksi komunitas aktif
                        </li>
                    </ul>
                </div>

                <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-orange-100">
                    <div class="w-16 h-16 bg-gradient-to-r from-orange-400 to-red-500 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-search text-2xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Pencarian Cerdas</h3>
                    <p class="text-gray-600 mb-6">
                        Algoritma pintar yang mencocokkan bakatmu dengan peluang karier yang sempurna
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-center text-gray-600">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            Matching otomatis dengan HRD
                        </li>
                        <li class="flex items-center text-gray-600">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            Rekomendasi peluang terbaik
                        </li>
                        <li class="flex items-center text-gray-600">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            Filter berdasarkan minat
                        </li>
                    </ul>
                </div>

                <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-red-100">
                    <div class="w-16 h-16 bg-gradient-to-r from-red-400 to-orange-500 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-network-wired text-2xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Hub Networking</h3>
                    <p class="text-gray-600 mb-6">
                        Terhubung dengan ekosistem profesional terbaik untuk mempercepat kesuksesanmu
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-center text-gray-600">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            Koneksi dengan alumni sukses
                        </li>
                        <li class="flex items-center text-gray-600">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            Mentoring dari profesional
                        </li>
                        <li class="flex items-center text-gray-600">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            Komunitas mahasiswa aktif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- Testimonials --}}
    <section id="testimoni" class="py-20 bg-white scroll-mt-20">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
            <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">Kisah Sukses yang Menginspirasi</h2>
            <p class="text-xl text-gray-600">Dengar langsung dari mahasiswa yang telah merasakan keajaiban BangunKarir</p>
            </div>

            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            <!-- Testimonial 1 -->
            <div class="bg-gradient-to-br from-orange-50 to-white rounded-2xl shadow-xl p-8 border-2 border-orange-100">
                <i class="fas fa-quote-left text-3xl text-orange-500 mb-6"></i>
                <p class="text-gray-700 mb-6 text-lg leading-relaxed">
                "BangunKarir benar-benar mengubah hidupku! Dalam 3 bulan, aku berhasil dapat magang di startup unicorn. Profilku yang keren di sini jadi daya tarik utama!"
                </p>
                <div class="flex items-center space-x-4">
                <div class="w-14 h-14 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center">
                    <span class="text-white font-bold text-lg">SB</span>
                </div>
                <div>
                    <div class="font-bold text-gray-900">Salsabila Putri</div>
                    <div class="text-orange-600 text-sm font-medium">Sistem Informasi '22</div>
                </div>
                </div>
            </div>

            <!-- Testimonial 2 -->
            <div class="bg-gradient-to-br from-red-50 to-white rounded-2xl shadow-xl p-8 border-2 border-red-100">
                <i class="fas fa-quote-left text-3xl text-red-500 mb-6"></i>
                <p class="text-gray-700 mb-6 text-lg leading-relaxed">
                "Dengan BangunKarir, aku mendapatkan kesempatan untuk berkolaborasi dengan perusahaan besar. Ini adalah langkah awal yang luar biasa untuk karierku!"
                </p>
                <div class="flex items-center space-x-4">
                <div class="w-14 h-14 bg-gradient-to-r from-green-500 to-blue-500 rounded-full flex items-center justify-center">
                    <span class="text-white font-bold text-lg">AR</span>
                </div>
                <div>
                    <div class="font-bold text-gray-900">Aldo Rinaldi</div>
                    <div class="text-red-600 text-sm font-medium">Teknik Informatika '23</div>
                </div>
                </div>
            </div>

            <!-- Testimonial 3 -->
            <div class="bg-gradient-to-br from-orange-50 to-white rounded-2xl shadow-xl p-8 border-2 border-orange-100">
                <i class="fas fa-quote-left text-3xl text-orange-500 mb-6"></i>
                <p class="text-gray-700 mb-6 text-lg leading-relaxed">
                "BangunKarir membantuku menemukan peluang yang tidak pernah aku bayangkan sebelumnya. Sangat membantu!"
                </p>
                <div class="flex items-center space-x-4">
                <div class="w-14 h-14 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center">
                    <span class="text-white font-bold text-lg">DA</span>
                </div>
                <div>
                    <div class="font-bold text-gray-900">Diana Ayu</div>
                    <div class="text-orange-600 text-sm font-medium">Manajemen '21</div>
                </div>
                </div>
            </div>
            <!-- Testimonial 4 -->
            <div class="bg-gradient-to-br from-red-50 to-white rounded-2xl shadow-xl p-8 border-2 border-red-100">
                <i class="fas fa-quote-left text-3xl text-red-500 mb-6"></i>
                <p class="text-gray-700 mb-6 text-lg leading-relaxed">
                    "Awalnya aku ragu, tapi setelah coba BangunKarir, ternyata ini platform yang benar-benar bantu aku berkembang. Sekarang aku punya portofolio yang bikin perusahaan tertarik!"
                </p>
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 bg-gradient-to-r from-red-500 to-orange-500 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-lg">AJ</span>
                    </div>
                    <div>
                        <div class="font-bold text-gray-900">Andika Julian</div>
                        <div class="text-red-600 text-sm font-medium">Teknik Logistik '20</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Call to Action --}}
    <section class="py-20 bg-gradient-to-r from-orange-500 to-red-500 text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl lg:text-5xl font-bold mb-6">Siap Memulai Perjalanan Kariermu?</h2>
            <p class="text-xl mb-8">Bergabunglah dengan BangunKarir dan raih kesuksesan yang kamu impikan!</p>
            <a href="{{ route('register') }}" class="bg-white text-orange-600 hover:bg-orange-100 px-6 py-3 rounded-lg font-bold transition-all mt-6 inline-block">
                Daftar Gratis Sekarang
            </a>
        </div>
    </section>    

    {{-- Footer --}}
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between gap-12">
                <!-- Tentang -->
                <div class="md:w-1/3">
                    <h3 class="text-lg font-bold mb-4">Tentang BangunKarir</h3>
                    <p class="text-gray-300 text-sm leading-relaxed">
                        BangunKarir adalah platform resmi Universitas Internasional Semen Indonesia (UISI) yang dirancang untuk mempersiapkan mahasiswa menghadapi dunia profesional melalui pengembangan personal branding, koneksi industri, dan showcase portofolio digital.
                    </p>
                </div>

                <!-- Kontak -->
                <div class="md:w-1/3">
                    <h3 class="text-lg font-bold mb-4">Kontak Resmi</h3>
                    <p class="text-gray-300 text-sm">
                        📍 Alamat:<br>
                        Universitas Internasional Semen Indonesia<br>
                        Kompleks PT. Semen Indonesia (Persero) Tbk.<br>
                        Jl. Veteran, Gresik, Jawa Timur 61122
                    </p>
                    <p class="text-gray-300 text-sm mt-4">
                        ☎️ Telp: (031) 3985482 / (031) 3981732 ext. 3662
                    </p>
                    <p class="text-gray-300 text-sm mt-4">
                        📧 Email: <a href="mailto:karir@uisi.ac.id" class="text-orange-400 hover:underline">karir@uisi.ac.id</a>
                    </p>
                </div>

                <!-- Sosial & Website -->
                <div class="md:w-1/3">
                    <h3 class="text-lg font-bold mb-4">Tautan Terkait</h3>
                    <p class="text-gray-300 text-sm mb-2">
                        🌐 Website Resmi UISI:<br>
                        <a href="https://uisi.ac.id" class="text-orange-400 hover:underline" target="_blank">uisi.ac.id</a>
                    </p>
                    <p class="text-gray-300 text-sm mb-2">
                        📱 Instagram Resmi Karir:<br>
                        <a href="https://www.instagram.com/kariruisi" class="text-orange-400 hover:underline" target="_blank">@KarirUISI</a>
                    </p>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-10 pt-6 text-center text-sm text-gray-400">
                &copy; {{ date('Y') }} BangunKarir - Universitas Internasional Semen Indonesia. All rights reserved.
            </div>
        </div>
    </footer>
</div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("menu-toggle").addEventListener("click", function () {
                const menu = document.getElementById("mobile-menu");
                menu.classList.toggle("hidden");
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>