<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VillageController;

Route::get('/', [VillageController::class, 'home'])->name('home');
Route::get('/profil', [VillageController::class, 'profil'])->name('profil');
Route::get('/kesehatan', [VillageController::class, 'kesehatan'])->name('kesehatan');
Route::get('/agribisnis', [VillageController::class, 'agribisnis'])->name('agribisnis');
Route::get('/keuangan', [VillageController::class, 'keuangan'])->name('keuangan');
Route::get('/umkm', [VillageController::class, 'umkm'])->name('umkm');
Route::get('/edukasi-5s', [VillageController::class, 'edukasi5s'])->name('edukasi5s');
Route::get('/admin', [VillageController::class, 'admin'])->name('admin');

Route::post('/kesehatan/skrining', [VillageController::class, 'storeSkrining'])->name('kesehatan.store');
Route::post('/admin/regulasi', [VillageController::class, 'storeRegulasi'])->name('admin.storeRegulasi');
Route::post('/admin/umkm', [VillageController::class, 'storeUmkm'])->name('admin.storeUmkm');


