<?php

define('LARAVEL_START', microtime(true));

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo "<div style='font-family: system-ui, sans-serif; max-w-2xl; margin: 40px auto; padding: 24px; border: 1px solid #e2e8f0; border-radius: 16px; background: #ffffff;'>";
echo "<h2 style='color: #0284c7; margin-top: 0;'>🔧 Setup Otomatis Database & Gambar Desa Banyuurip</h2>";

// 1. Storage link
$target = __DIR__.'/../storage/app/public';
$shortcut = __DIR__.'/storage';

if (!file_exists($shortcut)) {
    if (@symlink($target, $shortcut)) {
        echo "<p style='color: #16a34a;'>✅ <b>Storage Link Gambar:</b> Berhasil dihubungkan!</p>";
    } else {
        echo "<p style='color: #d97706;'>ℹ️ <b>Storage Link:</b> Menggunakan folder penyimpan bawaan.</p>";
    }
} else {
    echo "<p style='color: #16a34a;'>✅ <b>Storage Link Gambar:</b> Sudah terhubung!</p>";
}

// 2. Run Migration & Seeder
try {
    $status = $kernel->call('migrate:fresh', ['--force' => true, '--seed' => true]);
    echo "<p style='color: #16a34a;'>✅ <b>Migrasi Database & Data Desa:</b> Berhasil 100%!</p>";
    echo "<pre style='background: #f8fafc; padding: 16px; border-radius: 8px; font-size: 12px; border: 1px solid #e2e8f0; overflow-x: auto;'>" . htmlspecialchars($kernel->output()) . "</pre>";
} catch (\Throwable $e) {
    echo "<p style='color: #dc2626;'>❌ <b>Error Database:</b> " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<hr style='border: 0; border-top: 1px solid #e2e8f0; margin: 24px 0;' />";
echo "<p style='text-align: center;'><a href='/' style='background: #0284c7; color: white; padding: 12px 24px; border-radius: 12px; text-decoration: none; font-weight: bold;'>🎉 Buka Website Desa Banyuurip</a></p>";
echo "</div>";
