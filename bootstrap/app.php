<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [\App\Http\Middleware\SetLocale::class]);

        // Railway (comme Heroku, Render, etc.) place l'app derrière un proxy inverse.
        // Sans ça, Laravel ne sait pas que la requête entrante est en HTTPS et génère
        // des URLs signées (Livewire upload, vérification email...) avec le mauvais
        // schéma, ce qui casse leur validation avec une erreur 401 "Invalid signature."
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();