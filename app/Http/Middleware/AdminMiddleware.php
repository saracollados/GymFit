<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        // Verifica si el usuario no está autenticado o no es administrador
        if (!Auth::check() || Auth::user()->role_id != 1) {
            // Redirige al usuario a donde desees si no tiene permiso
            return redirect('/login');
        }

        return $next($request);
    }
}
