<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminClasesUserMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        $user = Auth::guard('personal')->user();

        // Verifica si el usuario no está autenticado o no es ser
        if ((Auth::guard('personal')->check() && ($user->role_id == 2 || $user->role_id == 1)) || Auth::guard('usuarios')->check()) {
            return $next($request);
        }
        
        return redirect('/login');
    }
}
