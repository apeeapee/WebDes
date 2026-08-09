<?php
// Force output immediately
if (ob_get_level()) ob_end_clean();
ob_implicit_flush(true);

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('max_execution_time', 600);
set_time_limit(600);

// Catch fatal errors
register_shutdown_function(function() {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        echo "<p style='color:#dc2626;font-family:system-ui;'>❌ <b>Fatal Error:</b> " . htmlspecialchars($error['message']) . "</p>";
        echo "<p style='color:#94a3b8;font-family:system-ui;font-size:12px;'>File: " . htmlspecialchars($error['file']) . " Line: " . $error['line'] . "</p>";
    }
});

echo "<html><head><title>Setup Desa Banyuurip</title></head><body>";
echo "<div style='font-family:system-ui,sans-serif;max-width:700px;margin:40px auto;padding:24px;border:1px solid #e2e8f0;border-radius:16px;background:#fff;'>";
echo "<h2 style='color:#0284c7;margin-top:0;'>🔧 Setup Otomatis Desa Banyuurip</h2>";
echo "<p>📌 <b>PHP:</b> " . phpversion() . "</p>";

// Load Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "<p style='color:#16a34a;'>✅ Laravel berhasil dimuat!</p>";

// DB check
try {
    \Illuminate\Support\Facades\DB::connection()->getPdo();
    echo "<p style='color:#16a34a;'>✅ Database terhubung!</p>";
} catch (\Throwable $e) {
    echo "<p style='color:#dc2626;'>❌ DB Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    die("</div></body></html>");
}

// Storage link
$target = __DIR__ . '/../storage/app/public';
$shortcut = __DIR__ . '/storage';
if (!file_exists($shortcut)) {
    @symlink($target, $shortcut);
}
echo "<p style='color:#16a34a;'>✅ Storage link diproses!</p>";

// MIGRATION
echo "<hr style='border:0;border-top:1px solid #e2e8f0;margin:16px 0;'/>";
echo "<p>⏳ <b>Menjalankan migrasi database...</b> (harap tunggu)</p>";

try {
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    $output = \Illuminate\Support\Facades\Artisan::output();
    echo "<p style='color:#16a34a;'>✅ <b>Migrasi berhasil!</b></p>";
    echo "<pre style='background:#f8fafc;padding:12px;border-radius:8px;font-size:11px;border:1px solid #e2e8f0;overflow:auto;max-height:250px;'>" . htmlspecialchars($output) . "</pre>";
} catch (\Throwable $e) {
    echo "<p style='color:#dc2626;'>❌ <b>Migration Error:</b> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p style='color:#94a3b8;font-size:11px;'>File: " . htmlspecialchars($e->getFile()) . " Line: " . $e->getLine() . "</p>";
    echo "<pre style='font-size:10px;background:#fef2f2;padding:12px;border-radius:8px;overflow:auto;max-height:200px;'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    die("</div></body></html>");
}

// SEEDER
echo "<p>⏳ <b>Memasukkan data awal desa...</b></p>";

try {
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
    $output = \Illuminate\Support\Facades\Artisan::output();
    echo "<p style='color:#16a34a;'>✅ <b>Data desa berhasil dimasukkan!</b></p>";
    echo "<pre style='background:#f8fafc;padding:12px;border-radius:8px;font-size:11px;border:1px solid #e2e8f0;overflow:auto;max-height:250px;'>" . htmlspecialchars($output) . "</pre>";
} catch (\Throwable $e) {
    echo "<p style='color:#dc2626;'>❌ <b>Seeder Error:</b> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<pre style='font-size:10px;background:#fef2f2;padding:12px;border-radius:8px;overflow:auto;max-height:200px;'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}

echo "<hr style='border:0;border-top:1px solid #e2e8f0;margin:24px 0;'/>";
echo "<p style='text-align:center;'><a href='/' style='background:#0284c7;color:white;padding:12px 24px;border-radius:12px;text-decoration:none;font-weight:bold;'>🎉 Buka Website Desa Banyuurip</a></p>";
echo "</div></body></html>";
