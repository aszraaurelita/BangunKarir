<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_sertifikat',
        'penyelenggara',
        'tahun',
        'deskripsi',
        'file_sertifikat'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFileUrlAttribute()
    {
        if ($this->file_sertifikat) {
            return asset('storage/' . $this->file_sertifikat);
        }
        return null;
    }
}
