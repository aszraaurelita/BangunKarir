<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'photo',
        'nim',
        'prodi',
        'semester',
        'ringkasan_pribadi',
        'kontak_email',
        'riwayat_prodi',
        'tahun_masuk',
        'ipk',
        'bidang_minat',
        'perusahaan_impian',
        'is_complete'
    ];

    protected $casts = [
        'is_complete' => 'boolean',
        'ipk' => 'decimal:2',
        'tahun_masuk' => 'integer',
        'semester' => 'integer'
    ];

    // Daftar Program Studi yang tersedia
    public static function getProdiOptions()
    {
        return [
            'Teknik Informatika' => 'Teknik Informatika',
            'Sistem Informasi' => 'Sistem Informasi',
            'Desain Komunikasi Visual (DKV)' => 'Desain Komunikasi Visual (DKV)',
            'Manajemen' => 'Manajemen',
            'Akuntansi' => 'Akuntansi',
            'Ekonomi Syariah' => 'Ekonomi Syariah',
            'Teknik Kimia' => 'Teknik Kimia',
            'Teknik Logistik' => 'Teknik Logistik',
            'Manajemen Rekayasa' => 'Manajemen Rekayasa',
            'Teknologi Industri Pertanian' => 'Teknologi Industri Pertanian',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

        public function getProgressPercentage()
    {
        $filledFields = 0;
        $totalFields = 7; // Sesuaikan jumlah total kolom yang wajib diisi

        if ($this->nim) $filledFields++;
        if ($this->prodi) $filledFields++;
        if ($this->semester) $filledFields++;
        if ($this->tahun_masuk) $filledFields++;
        if ($this->ipk) $filledFields++;
        if ($this->ringkasan_pribadi) $filledFields++;
        if ($this->bidang_minat) $filledFields++;

        return round(($filledFields / $totalFields) * 100);
    }


    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        return null;
    }

    public function getFormattedIpkAttribute()
    {
        return number_format($this->ipk, 2);
    }
}
