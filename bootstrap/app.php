<?php

use App\Http\Middleware\AddLoginAsToActivity;
use App\Http\Middleware\Admin2Auth;
use App\Http\Middleware\CacheStaticAssets;
use App\Http\Middleware\DeleteMiddleware;
use App\Http\Middleware\HoneypotProtection;
use App\Http\Middleware\RateLimitForms;
use App\Http\Middleware\SuperUser;
use App\Http\Middleware\Traffic;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Apply cache headers globally to static assets
        $middleware->append(CacheStaticAssets::class);

        $middleware->alias([
            'Traffic' => Traffic::class,
            'AddLoginAsToActivity' => AddLoginAsToActivity::class,
            'Delete' => DeleteMiddleware::class,
            'SuperUser' => SuperUser::class,
            'honeypot' => HoneypotProtection::class,
            'rate.limit.forms' => RateLimitForms::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
