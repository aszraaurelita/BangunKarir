<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_proyek',
        'deskripsi_proyek',
        'tanggal_pelaksanaan',
        'tautan'
    ];

    protected $casts = [
        'tanggal_pelaksanaan' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
