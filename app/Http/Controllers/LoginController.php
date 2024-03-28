<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller; 
use App\Models\Usuario;
use App\Models\Personal;

class LoginController extends Controller {
    public function login(Request $request) {
        $credentials = $request->only('email', 'password');
        $userType = $request->input('user_type');
        
        // Determina el guard basado en el tipo de usuario
        $guard = $userType === 'personal' ? 'personal' : 'usuarios';

        if ($userType === 'personal' && Auth::guard('personal')->attempt($credentials)) {
            
            $usuario_id = Auth::guard('personal')->id();
            $usuarioInfo = Personal::getPersonalInfoSession($usuario_id);
            session(['userInfo' => $usuarioInfo]);
            
            $user = Auth::guard('personal')->user();
            session(['userType' => 'personal']);
            if ($user->role_id == 1) {
                session(['isAdmin' => true]);
                return redirect()->intended('/dashboard');
            } elseif ($user->role_id == 2) {
                session(['isClases' => true]);
                return redirect()->intended('/mostrarReservasClases');
            }elseif ($user->role_id == 3 || $user->role_id == 4) {
                session(['isServicios' => true]);
                return redirect()->intended('/mostrarReservasServicios');
            }

        } elseif ($userType !== 'personal' && Auth::guard('usuarios')->attempt($credentials)) {
            
            $usuario_id = Auth::id();
            $usuarioInfo = Usuario::getUsuarioInfoSession($usuario_id);
            session(['userType' => 'usuario']);
            session(['userInfo' => $usuarioInfo]);
            return redirect()->intended('/mostrarReservasClases');
        }
    
        return back()->withErrors(['email' => 'Las credenciales no coinciden con nuestros registros.']);
    }

    public function logout(Request $request) {
        // Cierra la sesión del usuario
        Auth::guard('personal')->logout();
        Auth::guard('usuarios')->logout();

        // Limpiar datos específicos del usuario en la sesión
        $request->session()->forget(['userInfo', 'userType', 'isAdmin', 'isClases', 'isServicios']);

        // Invalida la sesión actual para evitar que se reutilice el token CSRF
        $request->session()->invalidate();

        // Regenera el token de la sesión para proteger contra ataques de fijación de sesión
        $request->session()->regenerateToken();

        // Redirecciona al usuario a la página de inicio
        return redirect('/');
    }

    public function showLoginForm(){
        return view('auth.login');
    }
}

?>