<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // --- TAMBAHKAN KODE INI ---
        $middleware->alias([
            'role' => \App\Http\Middleware\CekRole::class,
            'nocache' => \App\Http\Middleware\PreventBackHistory::class,
        ]);
        // -------------------------
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->renderable(function (\Throwable $e) {
            // Cegat semua exception sebelum masuk ke View Error Handler
            dd(
                'ERROR ASLI SEBELUM CRASH VIEW:',
                $e->getMessage(),
                $e->getFile() . ':' . $e->getLine(),
                $e->getTraceAsString()
            );
        });
    })->create();
