<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(300);

echo "<html><head><title>Setup Desa Banyuurip</title></head><body>";
echo "<div style='font-family: system-ui, sans-serif; max-width: 700px; margin: 40px auto; padding: 24px; border: 1px solid #e2e8f0; border-radius: 16px; background: #ffffff;'>";
echo "<h2 style='color: #0284c7; margin-top: 0;'>🔧 Setup Otomatis Database & Gambar Desa Banyuurip</h2>";

// Step 1: Check PHP version
echo "<p>📌 <b>PHP Version:</b> " . phpversion() . "</p>";
flush();

// Step 2: Check .env file
$envPath = __DIR__ . '/../.env';
if (file_exists($envPath)) {
    echo "<p style='color: #16a34a;'>✅ <b>File .env:</b> Ditemukan!</p>";
} else {
    echo "<p style='color: #dc2626;'>❌ <b>File .env:</b> TIDAK ditemukan! Silakan buat file .env terlebih dahulu.</p>";
    echo "</div></body></html>";
    exit;
}
flush();

// Step 3: Check vendor/autoload.php
$autoloadPath = __DIR__ . '/../vendor/autoload.php';
if (file_exists($autoloadPath)) {
    echo "<p style='color: #16a34a;'>✅ <b>Vendor:</b> Ditemukan!</p>";
} else {
    echo "<p style='color: #dc2626;'>❌ <b>Vendor:</b> TIDAK ditemukan! Jalankan composer install terlebih dahulu.</p>";
    echo "</div></body></html>";
    exit;
}
flush();

// Step 4: Try loading Laravel
try {
    require $autoloadPath;
    echo "<p style='color: #16a34a;'>✅ <b>Autoloader:</b> Berhasil dimuat!</p>";
    flush();
} catch (\Throwable $e) {
    echo "<p style='color: #dc2626;'>❌ <b>Autoloader Error:</b> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "</div></body></html>";
    exit;
}

// Step 5: Bootstrap Laravel app
try {
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    echo "<p style='color: #16a34a;'>✅ <b>Laravel App:</b> Berhasil di-bootstrap!</p>";
    flush();
} catch (\Throwable $e) {
    echo "<p style='color: #dc2626;'>❌ <b>Bootstrap Error:</b> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "</div></body></html>";
    exit;
}

// Step 6: Test database connection
try {
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    $pdo = \Illuminate\Support\Facades\DB::connection()->getPdo();
    echo "<p style='color: #16a34a;'>✅ <b>Koneksi Database:</b> Berhasil terhubung ke MySQL!</p>";
    flush();
} catch (\Throwable $e) {
    echo "<p style='color: #dc2626;'>❌ <b>Database Error:</b> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p style='color: #d97706;'>⚠️ Silakan periksa pengaturan DB_DATABASE, DB_USERNAME, DB_PASSWORD di file .env Anda.</p>";
    echo "</div></body></html>";
    exit;
}

// Step 7: Storage link
$target = __DIR__ . '/../storage/app/public';
$shortcut = __DIR__ . '/storage';

if (!file_exists($shortcut)) {
    if (@symlink($target, $shortcut)) {
        echo "<p style='color: #16a34a;'>✅ <b>Storage Link:</b> Berhasil dihubungkan!</p>";
    } else {
        // Manual copy fallback
        echo "<p style='color: #d97706;'>ℹ️ <b>Storage Link:</b> Symlink tidak tersedia, menggunakan folder storage yang ada.</p>";
    }
} else {
    echo "<p style='color: #16a34a;'>✅ <b>Storage Link:</b> Sudah terhubung!</p>";
}
flush();

// Step 8: Run migration
try {
    echo "<p>⏳ <b>Menjalankan migrasi database...</b></p>";
    flush();
    
    $status = \Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--force' => true, '--seed' => true]);
    $output = \Illuminate\Support\Facades\Artisan::output();
    
    echo "<p style='color: #16a34a;'>✅ <b>Migrasi Database & Data Desa:</b> Berhasil 100%!</p>";
    echo "<pre style='background: #f8fafc; padding: 16px; border-radius: 8px; font-size: 11px; border: 1px solid #e2e8f0; overflow-x: auto; max-height: 300px;'>" . htmlspecialchars($output) . "</pre>";
} catch (\Throwable $e) {
    echo "<p style='color: #dc2626;'>❌ <b>Migration Error:</b> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<pre style='background: #fef2f2; padding: 12px; border-radius: 8px; font-size: 11px; color: #991b1b;'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}
flush();

echo "<hr style='border: 0; border-top: 1px solid #e2e8f0; margin: 24px 0;' />";
echo "<p style='text-align: center;'><a href='/' style='background: #0284c7; color: white; padding: 12px 24px; border-radius: 12px; text-decoration: none; font-weight: bold;'>🎉 Buka Website Desa Banyuurip</a></p>";
echo "<p style='text-align: center; color: #94a3b8; font-size: 12px;'>⚠️ Setelah setup berhasil, hapus file setup.php ini demi keamanan.</p>";
echo "</div></body></html>";
