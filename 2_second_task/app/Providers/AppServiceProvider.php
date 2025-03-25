<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ✅ Register Spatie Middleware Manually
        Route::aliasMiddleware('role', \Spatie\Permission\Middleware\RoleMiddleware::class);
        Route::aliasMiddleware('permission', \Spatie\Permission\Middleware\PermissionMiddleware::class);
        Route::aliasMiddleware('role_or_permission', \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class);
    }
}
