<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('max_execution_time', 600);
set_time_limit(600);

// ========== JALANKAN SEMUA PROSES DULU (SEBELUM OUTPUT) ==========
$results = [];

// 1. Load Laravel
try {
    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    $results['laravel'] = ['status' => true, 'msg' => 'Laravel berhasil dimuat!'];
} catch (\Throwable $e) {
    $results['laravel'] = ['status' => false, 'msg' => $e->getMessage()];
}

// 2. DB Connection
if ($results['laravel']['status']) {
    try {
        \Illuminate\Support\Facades\DB::connection()->getPdo();
        $results['db'] = ['status' => true, 'msg' => 'Database terhubung!'];
    } catch (\Throwable $e) {
        $results['db'] = ['status' => false, 'msg' => $e->getMessage()];
    }
}

// 3. Storage link
if (isset($results['db']) && $results['db']['status']) {
    $target = __DIR__ . '/../storage/app/public';
    $shortcut = __DIR__ . '/storage';
    if (!file_exists($shortcut)) {
        @symlink($target, $shortcut);
    }
    $results['storage'] = ['status' => true, 'msg' => 'Storage link diproses!'];
}

// 4. Migration
if (isset($results['db']) && $results['db']['status']) {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $results['migrate'] = ['status' => true, 'msg' => 'Migrasi berhasil!', 'output' => \Illuminate\Support\Facades\Artisan::output()];
    } catch (\Throwable $e) {
        $results['migrate'] = ['status' => false, 'msg' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()];
    }
}

// 5. Seeder
if (isset($results['migrate']) && $results['migrate']['status']) {
    try {
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
        $results['seed'] = ['status' => true, 'msg' => 'Data desa berhasil dimasukkan!', 'output' => \Illuminate\Support\Facades\Artisan::output()];
    } catch (\Throwable $e) {
        $results['seed'] = ['status' => false, 'msg' => $e->getMessage()];
    }
}

// ========== TAMPILKAN HASIL ==========
?>
<!DOCTYPE html>
<html><head><title>Setup Desa Banyuurip</title></head>
<body style="margin:0;padding:0;background:#f8fafc;">
<div style="font-family:system-ui,sans-serif;max-width:700px;margin:40px auto;padding:24px;border:1px solid #e2e8f0;border-radius:16px;background:#fff;">
<h2 style="color:#0284c7;margin-top:0;">🔧 Setup Otomatis Desa Banyuurip</h2>
<p>📌 <b>PHP:</b> <?= phpversion() ?></p>

<?php foreach ($results as $key => $r): ?>
    <?php if ($r['status']): ?>
        <p style="color:#16a34a;">✅ <b><?= htmlspecialchars($r['msg']) ?></b></p>
        <?php if (isset($r['output'])): ?>
            <pre style="background:#f8fafc;padding:12px;border-radius:8px;font-size:11px;border:1px solid #e2e8f0;overflow:auto;max-height:200px;"><?= htmlspecialchars($r['output']) ?></pre>
        <?php endif; ?>
    <?php else: ?>
        <p style="color:#dc2626;">❌ <b>Error (<?= $key ?>):</b> <?= htmlspecialchars($r['msg']) ?></p>
        <?php if (isset($r['file'])): ?>
            <p style="color:#94a3b8;font-size:11px;">File: <?= htmlspecialchars($r['file']) ?> Line: <?= $r['line'] ?></p>
        <?php endif; ?>
    <?php endif; ?>
<?php endforeach; ?>

<hr style="border:0;border-top:1px solid #e2e8f0;margin:24px 0;"/>
<p style="text-align:center;"><a href="/" style="background:#0284c7;color:white;padding:12px 24px;border-radius:12px;text-decoration:none;font-weight:bold;">🎉 Buka Website Desa Banyuurip</a></p>
<p style="text-align:center;color:#94a3b8;font-size:12px;">⚠️ Setelah berhasil, hapus file setup.php demi keamanan.</p>
</div>
</body></html>
