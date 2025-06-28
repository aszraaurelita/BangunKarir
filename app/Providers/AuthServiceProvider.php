<?php

namespace App\Providers;

use App\Models\Post;
use App\Policies\PostPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Daftar policy model yang digunakan oleh aplikasi.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Post::class => PostPolicy::class,
        // Tambahkan model lain di sini jika perlu
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Tidak perlu daftarkan Gate di sini jika sudah pakai Policy
    }
}
