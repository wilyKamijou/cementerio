<?php

use App\Http\Middleware\VerificarPermiso;
use App\Http\Middleware\PermisoAny;
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
        // 👇 REGISTRAR EL MIDDLEWARE CON ALIAS
        $middleware->alias([
            'permiso' => VerificarPermiso::class,
            'permiso.any' => PermisoAny::class,
            'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
            // puedes agregar más middlewares aquí
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
