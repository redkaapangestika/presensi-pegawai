<?php

// Vercel Serverless Entrypoint (Laravel 11)

$app = require __DIR__ . '/../bootstrap/app.php';

// Memaksa seluruh operasi Storage (Log, View Caches, Sessions) ke direktori /tmp
$app->useStoragePath('/tmp/storage');

// Membuat struktur folder jika belum ada agar view dan sesssions tidak crash
$paths = [
    '/tmp/storage/app',
    '/tmp/storage/logs',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
];

foreach ($paths as $path) {
    if (!is_dir($path)) {
        @mkdir($path, 0777, true);
    }
}

$app->handleRequest(Illuminate\Http\Request::capture());
