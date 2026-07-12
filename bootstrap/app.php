<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        // ── Middlewares de rôles AGesP ────────────────────────
        $middleware->alias([
            'admin.only'          => \App\Http\Middleware\AdminOnly::class,
            'candidat.only'       => \App\Http\Middleware\CandidatOnly::class,
            'moniteur.only'       => \App\Http\Middleware\MoniteurOnly::class,
            'admin-or-moniteur'   => \App\Http\Middleware\AdminOrMoniteur::class,
            'admin.or.moniteur'   => \App\Http\Middleware\AdminOrMoniteur::class,
            'admin.or.secretaire' => \App\Http\Middleware\AdminOrSecretaire::class,
            'staff'               => \App\Http\Middleware\Staff::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();