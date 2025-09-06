<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
   ->withRouting(
    web: __DIR__.'/../routes/web.php',
    api: __DIR__.'/../routes/api.php',
    // --- THIS IS THE CRITICAL FIX ---
    // We are telling Laravel to use the 'api' middleware group,
    // which includes the necessary session handling.
    apiPrefix: 'api',
    // --------------------------------
    commands: __DIR__.'/../routes/console.php',
    health: '/up',
)
   ->withMiddleware(function (Middleware $middleware) {
    $middleware->statefulApi();

    // This ensures the CSRF token is correctly handled for your SPA
    $middleware->validateCsrfTokens(except: [
        'api/*' // Exclude all API routes from standard web CSRF checks, as Sanctum handles it
    ]);
})
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
