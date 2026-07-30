<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesaAntikorupsi extends Model
{
    use HasFactory;

    protected $table = 'desa_antikorupsis';

    protected $fillable = [
        'nomor',
        'judul',
        'kategori',
        'deskripsi',
        'link_drive',
        'status',
        'tanggal',
    ];
}
