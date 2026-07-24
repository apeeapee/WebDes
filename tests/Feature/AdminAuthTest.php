<?php

use App\Models\User;
use App\Models\Berita;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('public pages are accessible without login', function () {
    $response = $this->get('/');
    $response->assertStatus(200);

    $response = $this->get('/profil');
    $response->assertStatus(200);

    $response = $this->get('/kesehatan');
    $response->assertStatus(200);
});

test('admin dashboard redirects to login page for guests', function () {
    $response = $this->get('/admin');
    $response->assertRedirect(route('admin.login'));
});

test('admin user can login and access admin dashboard', function () {
    $admin = User::factory()->create([
        'email' => 'admin@banyuurip.desa.id',
        'password' => bcrypt('password'),
        'role' => 'admin',
    ]);

    $response = $this->post(route('admin.login.submit'), [
        'email' => 'admin@banyuurip.desa.id',
        'password' => 'password',
    ]);

    $response->assertRedirect(route('admin'));
    $this->assertAuthenticatedAs($admin);

    // Assert admin can access dashboard
    $dashboardResponse = $this->actingAs($admin)->get('/admin');
    $dashboardResponse->assertStatus(200);
});

test('non-admin user cannot login and is redirected back', function () {
    $user = User::factory()->create([
        'email' => 'user@banyuurip.desa.id',
        'password' => bcrypt('password'),
        'role' => 'user',
    ]);

    $response = $this->post(route('admin.login.submit'), [
        'email' => 'user@banyuurip.desa.id',
        'password' => 'password',
    ]);

    $response->assertSessionHasErrors(['email']);
    $this->assertGuest();
});

test('admin user can logout', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $response = $this->actingAs($admin)->post(route('admin.logout'));

    $response->assertRedirect(route('home'));
    $this->assertGuest();
});

test('admin can access berita index and perform CRUD', function () {
    Storage::fake('public');

    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    // 1. Read
    $response = $this->actingAs($admin)->get(route('admin.berita.index'));
    $response->assertStatus(200);

    // 2. Create
    $imageFile = UploadedFile::fake()->image('news.jpg');
    $response = $this->actingAs($admin)->post(route('admin.berita.store'), [
        'judul' => 'Berita KKN Baru',
        'ringkasan' => 'Ringkasan berita KKN terbaru di desa Banyuurip.',
        'kategori' => 'Edukasi',
        'tanggal' => '18 Juli 2026',
        'gambar' => $imageFile,
    ]);
    $response->assertRedirect(route('admin.berita.index'));
    $this->assertDatabaseHas('beritas', ['judul' => 'Berita KKN Baru']);

    $berita = Berita::where('judul', 'Berita KKN Baru')->first();
    expect($berita->gambar)->not->toBeNull();
    
    $storedPath = str_replace('storage/', '', $berita->gambar);
    Storage::disk('public')->assertExists($storedPath);

    // 3. Update
    $newImageFile = UploadedFile::fake()->image('news_updated.jpg');
    $response = $this->actingAs($admin)->put(route('admin.berita.update', $berita->id), [
        'judul' => 'Berita KKN Terupdate',
        'ringkasan' => 'Ringkasan berita KKN terbaru di desa Banyuurip.',
        'kategori' => 'Edukasi',
        'tanggal' => '18 Juli 2026',
        'gambar' => $newImageFile,
    ]);
    $response->assertRedirect(route('admin.berita.index'));
    $this->assertDatabaseHas('beritas', ['judul' => 'Berita KKN Terupdate']);
    
    $berita->refresh();
    $newStoredPath = str_replace('storage/', '', $berita->gambar);
    Storage::disk('public')->assertExists($newStoredPath);
    Storage::disk('public')->assertMissing($storedPath);

    // 4. Delete
    $response = $this->actingAs($admin)->delete(route('admin.berita.destroy', $berita->id));
    $response->assertRedirect(route('admin.berita.index'));
    $this->assertDatabaseMissing('beritas', ['id' => $berita->id]);
    Storage::disk('public')->assertMissing($newStoredPath);
});

test('non-admin user cannot access admin berita index', function () {
    $user = User::factory()->create([
        'role' => 'user',
    ]);

    $response = $this->actingAs($user)->get(route('admin.berita.index'));
    $response->assertRedirect(route('admin.login'));
});

test('admin can access apbdes index and perform CRUD', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    // 1. Read
    $response = $this->actingAs($admin)->get(route('admin.apbdes.index'));
    $response->assertStatus(200);

    // 2. Create
    $response = $this->actingAs($admin)->post(route('admin.apbdes.store'), [
        'kategori' => 'pendapatan',
        'rincian' => 'Sumbangan Warga',
        'jumlah' => 125000000,
        'persen' => 10,
    ]);
    $response->assertRedirect(route('admin.apbdes.index'));
    $this->assertDatabaseHas('apbdes', ['rincian' => 'Sumbangan Warga']);

    $apbdes = \App\Models\Apbdes::where('rincian', 'Sumbangan Warga')->first();

    // 3. Update
    $response = $this->actingAs($admin)->put(route('admin.apbdes.update', $apbdes->id), [
        'kategori' => 'pendapatan',
        'rincian' => 'Sumbangan Warga Terkini',
        'jumlah' => 135000000,
        'persen' => 11,
    ]);
    $response->assertRedirect(route('admin.apbdes.index'));
    $this->assertDatabaseHas('apbdes', ['rincian' => 'Sumbangan Warga Terkini']);

    // 4. Delete
    $response = $this->actingAs($admin)->delete(route('admin.apbdes.destroy', $apbdes->id));
    $response->assertRedirect(route('admin.apbdes.index'));
    $this->assertDatabaseMissing('apbdes', ['id' => $apbdes->id]);
});

test('admin can update agribisnis stats', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.komoditas.index'));
    $response->assertStatus(200);

    $response = $this->actingAs($admin)->put(route('admin.agribisnis.stats.update'), [
        'luas_lahan' => '260 Hektar',
        'jumlah_produksi' => '1.700 Ton',
        'jumlah_petani' => '540 Orang',
        'jumlah_kelompok_tani' => '14 Kelompok',
    ]);
    $response->assertRedirect(route('admin.komoditas.index'));
    $this->assertDatabaseHas('agribisnis_stats', [
        'luas_lahan' => '260 Hektar',
        'jumlah_produksi' => '1.700 Ton',
        'jumlah_petani' => '540 Orang',
        'jumlah_kelompok_tani' => '14 Kelompok',
    ]);
});

test('admin can manage regulasi with external link', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    // 1. Create
    $response = $this->actingAs($admin)->post(route('admin.regulasi.store'), [
        'nomor' => 'Perdes No. 10 Tahun 2026',
        'judul' => 'Regulasi Uji Coba Link',
        'kategori' => 'Peraturan Desa',
        'link_url' => 'https://drive.google.com/file/d/1234567890/view',
    ]);

    $response->assertRedirect(route('admin.regulasi.index'));
    $this->assertDatabaseHas('regulasis', [
        'nomor' => 'Perdes No. 10 Tahun 2026',
        'judul' => 'Regulasi Uji Coba Link',
        'link_url' => 'https://drive.google.com/file/d/1234567890/view',
    ]);

    $regulasi = \App\Models\Regulasi::where('nomor', 'Perdes No. 10 Tahun 2026')->first();

    // 2. Delete
    $response = $this->actingAs($admin)->delete(route('admin.regulasi.destroy', $regulasi->id));
    $response->assertRedirect(route('admin.regulasi.index'));
    $this->assertDatabaseMissing('regulasis', ['id' => $regulasi->id]);
});
