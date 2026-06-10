<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

// Ensure the view service provider is registered in serverless/runtime contexts.
$app->register(Illuminate\View\ViewServiceProvider::class, force: true);

// Auto-run migration on Vercel if sqlite database file does not exist
$dbPath = getenv('DB_DATABASE');
if (getenv('VERCEL') && getenv('DB_CONNECTION') === 'sqlite' && $dbPath) {
    if (!file_exists($dbPath) || filesize($dbPath) === 0) {
        @touch($dbPath);
        try {
            $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
            $kernel->call('migrate:fresh', ['--force' => true, '--seed' => true]);
        } catch (\Throwable $migrationError) {
            error_log('Auto migration error: ' . $migrationError->getMessage());
        }
    }
}

$app->handleRequest(Request::capture());
