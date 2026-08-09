<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VillageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

// Public user routes
Route::get('/', [VillageController::class, 'home'])->name('home');
Route::get('/profil', [VillageController::class, 'profil'])->name('profil');
Route::get('/kesehatan', [VillageController::class, 'kesehatan'])->name('kesehatan');
Route::get('/agribisnis', [VillageController::class, 'agribisnis'])->name('agribisnis');
Route::get('/keuangan', [VillageController::class, 'keuangan'])->name('keuangan');
Route::get('/hukum', [VillageController::class, 'hukum'])->name('hukum');
Route::get('/berita', [VillageController::class, 'berita'])->name('berita');
Route::get('/desa-antikorupsi', [VillageController::class, 'desaAntikorupsi'])->name('desa-antikorupsi');
Route::get('/umkm', [VillageController::class, 'umkm'])->name('umkm');
Route::get('/edukasi-5s', [VillageController::class, 'edukasi5s'])->name('edukasi5s');
Route::post('/kesehatan/skrining', [VillageController::class, 'storeSkrining'])->name('kesehatan.store');

// Admin Auth routes
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Protected Admin routes
Route::middleware(['admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::put('/admin/stats', [AdminController::class, 'updateStats'])->name('admin.stats.update');
    
    // Berita CRUD
    Route::get('/admin/berita', [AdminController::class, 'beritaIndex'])->name('admin.berita.index');
    Route::post('/admin/berita', [AdminController::class, 'beritaStore'])->name('admin.berita.store');
    Route::put('/admin/berita/{id}', [AdminController::class, 'beritaUpdate'])->name('admin.berita.update');
    Route::delete('/admin/berita/{id}', [AdminController::class, 'beritaDestroy'])->name('admin.berita.destroy');

    // Sejarah CRUD
    Route::get('/admin/sejarah', [AdminController::class, 'sejarahIndex'])->name('admin.sejarah.index');
    Route::post('/admin/sejarah', [AdminController::class, 'sejarahStore'])->name('admin.sejarah.store');
    Route::put('/admin/sejarah/{id}', [AdminController::class, 'sejarahUpdate'])->name('admin.sejarah.update');
    Route::delete('/admin/sejarah/{id}', [AdminController::class, 'sejarahDestroy'])->name('admin.sejarah.destroy');

    // Perangkat Desa CRUD
    Route::get('/admin/perangkat', [AdminController::class, 'perangkatIndex'])->name('admin.perangkat.index');
    Route::post('/admin/perangkat', [AdminController::class, 'perangkatStore'])->name('admin.perangkat.store');
    Route::put('/admin/perangkat/{id}', [AdminController::class, 'perangkatUpdate'])->name('admin.perangkat.update');
    Route::delete('/admin/perangkat/{id}', [AdminController::class, 'perangkatDestroy'])->name('admin.perangkat.destroy');

    // Komoditas CRUD
    Route::get('/admin/komoditas', [AdminController::class, 'komoditasIndex'])->name('admin.komoditas.index');
    Route::post('/admin/komoditas', [AdminController::class, 'komoditasStore'])->name('admin.komoditas.store');
    Route::put('/admin/komoditas/{id}', [AdminController::class, 'komoditasUpdate'])->name('admin.komoditas.update');
    Route::delete('/admin/komoditas/{id}', [AdminController::class, 'komoditasDestroy'])->name('admin.komoditas.destroy');
    Route::put('/admin/agribisnis/stats', [AdminController::class, 'updateAgribisnisStats'])->name('admin.agribisnis.stats.update');

    // Aset Tani CRUD
    Route::get('/admin/asettani', [AdminController::class, 'asetTaniIndex'])->name('admin.asettani.index');
    Route::post('/admin/asettani', [AdminController::class, 'asetTaniStore'])->name('admin.asettani.store');
    Route::put('/admin/asettani/{id}', [AdminController::class, 'asetTaniUpdate'])->name('admin.asettani.update');
    Route::delete('/admin/asettani/{id}', [AdminController::class, 'asetTaniDestroy'])->name('admin.asettani.destroy');

    // Regulasi CRUD
    Route::get('/admin/regulasi', [AdminController::class, 'regulasiIndex'])->name('admin.regulasi.index');
    Route::post('/admin/regulasi', [AdminController::class, 'regulasiStore'])->name('admin.regulasi.store');
    Route::put('/admin/regulasi/{id}', [AdminController::class, 'regulasiUpdate'])->name('admin.regulasi.update');
    Route::delete('/admin/regulasi/{id}', [AdminController::class, 'regulasiDestroy'])->name('admin.regulasi.destroy');

    // UMKM CRUD
    Route::get('/admin/umkm', [AdminController::class, 'umkmIndex'])->name('admin.umkm.index');
    Route::post('/admin/umkm', [AdminController::class, 'umkmStore'])->name('admin.umkm.store');
    Route::put('/admin/umkm/{id}', [AdminController::class, 'umkmUpdate'])->name('admin.umkm.update');
    Route::delete('/admin/umkm/{id}', [AdminController::class, 'umkmDestroy'])->name('admin.umkm.destroy');

    // Skrining ISPA CRUD
    Route::get('/admin/skrining', [AdminController::class, 'skriningIndex'])->name('admin.skrining.index');
    Route::delete('/admin/skrining/{id}', [AdminController::class, 'skriningDestroy'])->name('admin.skrining.destroy');

    // APBDes CRUD
    Route::get('/admin/apbdes', [AdminController::class, 'apbdesIndex'])->name('admin.apbdes.index');
    Route::post('/admin/apbdes', [AdminController::class, 'apbdesStore'])->name('admin.apbdes.store');
    Route::put('/admin/apbdes/{id}', [AdminController::class, 'apbdesUpdate'])->name('admin.apbdes.update');
    Route::delete('/admin/apbdes/{id}', [AdminController::class, 'apbdesDestroy'])->name('admin.apbdes.destroy');

    // Desa Antikorupsi CRUD
    Route::get('/admin/antikorupsi', [AdminController::class, 'antikorupsiIndex'])->name('admin.antikorupsi.index');
    Route::post('/admin/antikorupsi', [AdminController::class, 'antikorupsiStore'])->name('admin.antikorupsi.store');
    Route::put('/admin/antikorupsi/{id}', [AdminController::class, 'antikorupsiUpdate'])->name('admin.antikorupsi.update');
    Route::delete('/admin/antikorupsi/{id}', [AdminController::class, 'antikorupsiDestroy'])->name('admin.antikorupsi.destroy');
});


