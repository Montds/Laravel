<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('limitador', function (Request $request) {
            // Limita a 2 peticiones por minuto por dirección IP
            return Limit::perMinute(2)->by($request->ip());
        });
        // Solo si la DB es muy antigua (MySQL < 5.7)
        Schema::defaultStringLength(191);
    }
}
