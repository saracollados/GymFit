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
            $usuarioInfo = Personal::getPersonalById($usuario_id);
            session(['userInfo' => $usuarioInfo]);
            
            $user = Auth::guard('personal')->user();
            session(['userType' => 'personal']);
            if ($user->role_id == 1) {
                session(['isAdmin' => true]);
            }

            return redirect()->intended('/mostrarReservasClases');
        } elseif ($userType !== 'personal' && Auth::guard('usuarios')->attempt($credentials)) {
            
            $usuario_id = Auth::id();
            $usuarioInfo = Usuario::getUsuarioById($usuario_id);
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
        $request->session()->forget(['userType', 'isAdmin']);

        // Invalida la sesión actual para evitar que se reutilice el token CSRF
        $request->session()->invalidate();

        // Regenera el token de la sesión para proteger contra ataques de fijación de sesión
        $request->session()->regenerateToken();

        // Redirecciona al usuario a la página de inicio o a donde prefieras después del logout
        return redirect('/');
    }

    public function showLoginForm(){
        return view('auth.login');
    }
}

?>