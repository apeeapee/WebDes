<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apbdes extends Model
{
    protected $table = 'apbdes';

    protected $fillable = [
        'kategori',
        'rincian',
        'jumlah',
        'persen',
    ];
}
