<?php

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
