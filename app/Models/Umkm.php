<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    protected $table = 'umkms';
    protected $fillable = [
        'nama', 'pemilik', 'kategori', 'kontak', 'alamat', 
        'deskripsi', 'omzet_bulanan', 'biaya_produksi', 'laba_bersih', 
        'pencatatan', 'produk', 'gambar'
    ];

    protected $casts = [
        'produk' => 'array'
    ];
}
