<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgribisnisStat extends Model
{
    use HasFactory;

    protected $table = 'agribisnis_stats';

    protected $fillable = [
        'luas_lahan',
        'jumlah_produksi',
        'jumlah_petani',
        'jumlah_kelompok_tani',
    ];
}
