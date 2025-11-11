<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Request;
use Illuminate\Cache\RateLimiting\Limit;
use App\Http\Middleware\CheckIfUserBlocked;
use Illuminate\Support\Facades\RateLimiter;
use Spatie\Permission\Middleware\RoleMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

// RateLimiter::for('book-search', function (Request $request){
//     return Limit::perMinute(4)->by($request->ip());
// });

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role'             => RoleMiddleware::class,
            'permission'       => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
            'not_blocked' => CheckIfUserBlocked::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
