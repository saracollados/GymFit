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
        $user = Auth::guard('personal')->user();

        // Verifica si el usuario no está autenticado o no es administrador
        if (!Auth::guard('personal')->check() || $user->role_id != 1) {
            return redirect('/login');
        }

        return $next($request);
    }
}
