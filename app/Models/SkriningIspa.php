<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkriningIspa extends Model
{
    protected $table = 'skrining_ispas';
    protected $fillable = ['nama_warga', 'usia', 'risiko', 'gejala', 'rekomendasi', 'status'];

    protected $casts = [
        'gejala' => 'array'
    ];
}
