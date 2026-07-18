<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regulasi extends Model
{
    protected $table = 'regulasis';
    protected $fillable = ['nomor', 'judul', 'kategori', 'file_path', 'tanggal'];
}
