<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;

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
    public function boot(): void{
         // Directiva para verificar si el usuario está autenticado con cualquier guard
        Blade::if('authany', function () {
            $guards = array_keys(config('auth.guards'));
            foreach ($guards as $guard) {
                if (Auth::guard($guard)->check()) {
                    return true;
                }
            }
            return false;
        });
    }
}
