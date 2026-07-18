<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerangkatDesa extends Model
{
    protected $table = 'perangkat_desas';
    protected $fillable = ['nama', 'jabatan', 'foto', 'kontak'];
}
