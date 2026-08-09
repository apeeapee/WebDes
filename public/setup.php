<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('max_execution_time', 600);
set_time_limit(600);

echo "<html><head><title>Setup Desa Banyuurip</title></head><body>";
echo "<div style='font-family: system-ui, sans-serif; max-width: 700px; margin: 40px auto; padding: 24px; border: 1px solid #e2e8f0; border-radius: 16px; background: #ffffff;'>";
echo "<h2 style='color: #0284c7; margin-top: 0;'>🔧 Setup Otomatis Database & Gambar Desa Banyuurip</h2>";
echo "<p>📌 <b>PHP Version:</b> " . phpversion() . "</p>";

// Check .env
$envPath = __DIR__ . '/../.env';
if (!file_exists($envPath)) {
    echo "<p style='color: #dc2626;'>❌ File .env tidak ditemukan!</p></div></body></html>";
    exit;
}
echo "<p style='color: #16a34a;'>✅ <b>File .env:</b> Ditemukan!</p>";

// Check vendor
$autoloadPath = __DIR__ . '/../vendor/autoload.php';
if (!file_exists($autoloadPath)) {
    echo "<p style='color: #dc2626;'>❌ Vendor tidak ditemukan!</p></div></body></html>";
    exit;
}
echo "<p style='color: #16a34a;'>✅ <b>Vendor:</b> Ditemukan!</p>";

// Load Laravel
try {
    require $autoloadPath;
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    echo "<p style='color: #16a34a;'>✅ <b>Laravel App:</b> Berhasil di-bootstrap!</p>";
} catch (\Throwable $e) {
    echo "<p style='color: #dc2626;'>❌ <b>Bootstrap Error:</b> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<pre style='font-size:11px;background:#fef2f2;padding:12px;border-radius:8px;overflow:auto;max-height:200px;'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    echo "</div></body></html>";
    exit;
}

// Test DB connection
try {
    $pdo = \Illuminate\Support\Facades\DB::connection()->getPdo();
    echo "<p style='color: #16a34a;'>✅ <b>Koneksi Database:</b> Berhasil terhubung ke MySQL!</p>";
} catch (\Throwable $e) {
    echo "<p style='color: #dc2626;'>❌ <b>Database Error:</b> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "</div></body></html>";
    exit;
}

// Storage link
$target = __DIR__ . '/../storage/app/public';
$shortcut = __DIR__ . '/storage';
if (!file_exists($shortcut)) {
    if (@symlink($target, $shortcut)) {
        echo "<p style='color: #16a34a;'>✅ <b>Storage Link:</b> Berhasil dihubungkan!</p>";
    } else {
        echo "<p style='color: #d97706;'>ℹ️ <b>Storage Link:</b> Symlink tidak tersedia (akan diatur manual).</p>";
    }
} else {
    echo "<p style='color: #16a34a;'>✅ <b>Storage Link:</b> Sudah terhubung!</p>";
}

// Step-by-step: First run migrate
echo "<hr style='border:0;border-top:1px solid #e2e8f0;margin:16px 0;'/>";
echo "<p>⏳ <b>Langkah 1:</b> Menjalankan migrasi database (membuat tabel)...</p>";

try {
    $status = \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    $output = \Illuminate\Support\Facades\Artisan::output();
    echo "<p style='color: #16a34a;'>✅ <b>Migrasi Database:</b> Berhasil!</p>";
    echo "<pre style='background:#f8fafc;padding:12px;border-radius:8px;font-size:11px;border:1px solid #e2e8f0;overflow:auto;max-height:200px;'>" . htmlspecialchars($output) . "</pre>";
} catch (\Throwable $e) {
    echo "<p style='color: #dc2626;'>❌ <b>Migration Error:</b> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<pre style='font-size:11px;background:#fef2f2;padding:12px;border-radius:8px;overflow:auto;max-height:300px;'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    echo "</div></body></html>";
    exit;
}

// Then run seeder
echo "<p>⏳ <b>Langkah 2:</b> Memasukkan data awal desa...</p>";

try {
    $status = \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
    $output = \Illuminate\Support\Facades\Artisan::output();
    echo "<p style='color: #16a34a;'>✅ <b>Data Awal Desa:</b> Berhasil dimasukkan!</p>";
    echo "<pre style='background:#f8fafc;padding:12px;border-radius:8px;font-size:11px;border:1px solid #e2e8f0;overflow:auto;max-height:200px;'>" . htmlspecialchars($output) . "</pre>";
} catch (\Throwable $e) {
    echo "<p style='color: #dc2626;'>❌ <b>Seeder Error:</b> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<pre style='font-size:11px;background:#fef2f2;padding:12px;border-radius:8px;overflow:auto;max-height:300px;'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}

echo "<hr style='border:0;border-top:1px solid #e2e8f0;margin:24px 0;'/>";
echo "<p style='text-align:center;'><a href='/' style='background:#0284c7;color:white;padding:12px 24px;border-radius:12px;text-decoration:none;font-weight:bold;'>🎉 Buka Website Desa Banyuurip</a></p>";
echo "<p style='text-align:center;color:#94a3b8;font-size:12px;'>⚠️ Setelah setup berhasil, hapus file setup.php demi keamanan.</p>";
echo "</div></body></html>";
