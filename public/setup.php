<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('max_execution_time', 600);
set_time_limit(600);

$results = [];
$results['php'] = phpversion();

// 1. Load Laravel
try {
    require __DIR__ . '/../vendor/autoload.php';
    
    // Force debug mode via env before bootstrap
    putenv('APP_DEBUG=true');
    $_ENV['APP_DEBUG'] = 'true';
    $_SERVER['APP_DEBUG'] = 'true';
    
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    $results['laravel'] = true;
} catch (\Throwable $e) {
    $results['laravel'] = false;
    $results['laravel_error'] = $e->getMessage();
}

// 2. DB Connection
if (!empty($results['laravel'])) {
    try {
        \Illuminate\Support\Facades\DB::connection()->getPdo();
        $results['db'] = true;
    } catch (\Throwable $e) {
        $results['db'] = false;
        $results['db_error'] = $e->getMessage();
    }
}

// 3. Storage link
if (!empty($results['db'])) {
    $target = __DIR__ . '/../storage/app/public';
    $shortcut = __DIR__ . '/storage';
    if (!file_exists($shortcut)) {
        @symlink($target, $shortcut);
    }
    $results['storage'] = true;
}

// 4. Migration (using Migrator directly)
if (!empty($results['db'])) {
    try {
        $migrator = $app->make('migrator');
        $output = new \Symfony\Component\Console\Output\BufferedOutput();
        $migrator->setOutput($output);
        
        if (!$migrator->repositoryExists()) {
            $app->make('migration.repository')->createRepository();
        }
        
        $migrator->run(database_path('migrations'));
        $results['migrate'] = true;
        $results['migrate_output'] = $output->fetch();
    } catch (\Throwable $e) {
        $results['migrate'] = false;
        $results['migrate_error'] = $e->getMessage();
        $results['migrate_detail'] = basename($e->getFile()) . ':' . $e->getLine();
    }
}

// 5. Seeder
if (!empty($results['migrate'])) {
    try {
        $seeder = $app->make(\Database\Seeders\DatabaseSeeder::class);
        $seeder->run();
        $results['seed'] = true;
    } catch (\Throwable $e) {
        $results['seed'] = false;
        $results['seed_error'] = $e->getMessage();
    }
}

// ========== OUTPUT ==========
?>
<!DOCTYPE html>
<html><head><title>Setup Desa Banyuurip</title></head>
<body style="margin:0;padding:0;background:#f8fafc;">
<div style="font-family:system-ui,sans-serif;max-width:700px;margin:40px auto;padding:24px;border:1px solid #e2e8f0;border-radius:16px;background:#fff;">
<h2 style="color:#0284c7;margin-top:0;">🔧 Setup Otomatis Desa Banyuurip</h2>
<p>📌 <b>PHP:</b> <?= $results['php'] ?></p>

<?php if (!empty($results['laravel'])): ?>
    <p style="color:#16a34a;">✅ Laravel berhasil dimuat!</p>
<?php else: ?>
    <p style="color:#dc2626;">❌ Laravel Error: <?= htmlspecialchars($results['laravel_error'] ?? '') ?></p>
<?php endif; ?>

<?php if (isset($results['db'])): ?>
    <?php if ($results['db']): ?>
        <p style="color:#16a34a;">✅ Database terhubung!</p>
    <?php else: ?>
        <p style="color:#dc2626;">❌ DB Error: <?= htmlspecialchars($results['db_error'] ?? '') ?></p>
    <?php endif; ?>
<?php endif; ?>

<?php if (!empty($results['storage'])): ?>
    <p style="color:#16a34a;">✅ Storage link diproses!</p>
<?php endif; ?>

<?php if (isset($results['migrate'])): ?>
    <?php if ($results['migrate']): ?>
        <p style="color:#16a34a;">✅ Migrasi database berhasil!</p>
        <?php if (!empty($results['migrate_output'])): ?>
            <pre style="background:#f8fafc;padding:12px;border-radius:8px;font-size:11px;border:1px solid #e2e8f0;overflow:auto;max-height:200px;"><?= htmlspecialchars($results['migrate_output']) ?></pre>
        <?php endif; ?>
    <?php else: ?>
        <p style="color:#dc2626;">❌ Migration Error: <?= htmlspecialchars($results['migrate_error'] ?? '') ?></p>
        <p style="color:#94a3b8;font-size:11px;"><?= htmlspecialchars($results['migrate_detail'] ?? '') ?></p>
    <?php endif; ?>
<?php endif; ?>

<?php if (isset($results['seed'])): ?>
    <?php if ($results['seed']): ?>
        <p style="color:#16a34a;">✅ Data desa berhasil dimasukkan!</p>
    <?php else: ?>
        <p style="color:#dc2626;">❌ Seeder Error: <?= htmlspecialchars($results['seed_error'] ?? '') ?></p>
    <?php endif; ?>
<?php endif; ?>

<hr style="border:0;border-top:1px solid #e2e8f0;margin:24px 0;"/>
<p style="text-align:center;"><a href="/" style="background:#0284c7;color:white;padding:12px 24px;border-radius:12px;text-decoration:none;font-weight:bold;">🎉 Buka Website Desa Banyuurip</a></p>
</div>
</body></html>
