<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komoditas extends Model
{
    protected $table = 'komoditas';
    protected $fillable = ['nama', 'jenis', 'luas_atau_jumlah', 'hasil', 'deskripsi', 'tipe'];
}
