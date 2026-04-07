<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',

        // Then: function() para registrar rutas que no sean api, web, etc. En este caso, para agregar la ruta personalizada admin.php
        then: function() {
            Route::middleware(['web', 'auth']) // El orden si importa primero cargamos la sesión (web) y luego comprobamos si está autenticado (auth).
            ->prefix('admin')
            ->name('admin.')
            ->group(base_path('routes/admin.php'));
        },
        
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
