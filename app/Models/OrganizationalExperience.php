<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationalExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_organisasi',
        'jabatan',
        'tanggal_masuk',
        'tanggal_selesai',
        'deskripsi_kegiatan'
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'tanggal_selesai' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
