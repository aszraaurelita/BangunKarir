<?php

// app/Models/InterestArea.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterestArea extends Model
{
    protected $fillable = ['nama_minat'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}