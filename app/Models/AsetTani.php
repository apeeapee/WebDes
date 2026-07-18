<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsetTani extends Model
{
    protected $table = 'aset_tanis';
    protected $fillable = ['nama', 'fungsi', 'kapasitas', 'pengelola'];
}
