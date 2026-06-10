<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

try {
    // ============================================================
    // Serverless entry point for Vercel (vercel-php runtime)
    // Buat semua direktori storage yang dibutuhkan Laravel di /tmp
    // (filesystem Vercel read-only kecuali /tmp)
    // ============================================================

    $dirs = [
        '/tmp/storage/app/public',
        '/tmp/storage/framework/cache/data',
        '/tmp/storage/framework/sessions',
        '/tmp/storage/framework/views',
        '/tmp/storage/framework/testing',
        '/tmp/storage/logs',
        '/tmp/database',
    ];

    foreach ($dirs as $dir) {
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
    }

    // Default serverless environment variables for Vercel
    if (!getenv('APP_ENV')) {
        putenv('APP_ENV=production');
    }

    if (!getenv('APP_DEBUG')) {
        putenv('APP_DEBUG=false');
    }

    if (!getenv('APP_KEY')) {
        $randomKey = base64_encode(random_bytes(32));
        putenv('APP_KEY=base64:'.$randomKey);
    }

    // Auto-detect APP_URL from the incoming request (fixes route() generating wrong URLs in Vercel)
    if (!getenv('APP_URL') || getenv('APP_URL') === 'http://localhost') {
        $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
        putenv('APP_URL=' . $scheme . '://' . $host);
        $_ENV['APP_URL'] = $scheme . '://' . $host;
    }

    if (!getenv('DB_CONNECTION')) {
        putenv('DB_CONNECTION=sqlite');
    }

    if (!getenv('DB_DATABASE')) {
        putenv('DB_DATABASE=/tmp/database/database.sqlite');
    }

    // Use cookie sessions and array cache in serverless mode.
    if (!getenv('SESSION_DRIVER')) {
        putenv('SESSION_DRIVER=cookie');
    }

    if (!getenv('CACHE_STORE')) {
        putenv('CACHE_STORE=array');
    }

    if (!getenv('QUEUE_CONNECTION')) {
        putenv('QUEUE_CONNECTION=sync');
    }

    require __DIR__ . '/../public/index.php';
} catch (Throwable $e) {
    error_log('Vercel serverless error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
    http_response_code(500);
    header('Content-Type: text/plain; charset=utf-8');
    echo "Vercel error:\n";
    echo $e->getMessage() . "\n";
    echo $e->getFile() . ':' . $e->getLine() . "\n\n";
    echo $e->getTraceAsString();
    exit(1);
}
