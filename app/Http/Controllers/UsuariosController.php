<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Reserva;
use App\Models\ReservaServicio;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsuariosController extends Controller {
    public function mostrarUsuarios() {
        $usuarios = Usuario::getAll();

        foreach ($usuarios as &$usuario) {
            $fecha_formateada = date('d-m-Y', strtotime($usuario->fecha_nacimiento));
            $usuario->fecha_nacimiento = $fecha_formateada;
        }

        $success = session('success');
        $error = session('error');

        return view('gymfit/usuarios/mostrarUsuarios', compact('usuarios', 'success', 'error'));
    }

    public function crearUsuarioForm() {
        $generos = Usuario::getGeneros();
        return view('gymfit/usuarios/crearUsuarioForm', compact('generos'));
    }

    public function crearUsuario(Request $request) {

        if (!$request->isMethod('post')) {
            return back();
        }

        $id_usuario = Usuario::create($request);

        if($id_usuario) {
            $success='El usuario se ha añadido con éxito.';
            return redirect('/mostrarUsuarios')->with(compact('success'));
        } else {
            $error='No se ha podido crear el usuario.';
            return redirect('/mostrarUsuarios')->with(compact('error'));
        }
    }

    public function verUsuario(Request $request) {
        $id = $request->post('id');
        $usuario = Usuario::getUsuarioById($id);
        
        $error = session('error');
        $success = session('success');

        return view('gymfit/usuarios/verUsuario', compact('usuario', 'success', 'error'));
    }

    public function verUsuarioGet() {
        $id = session('id');;
        $usuario = Usuario::getUsuarioById($id);
        
        $error = session('error');
        $success = session('success');

        return view('gymfit/usuarios/verUsuario', compact('usuario', 'success', 'error'));
    }

    public function editarUsuarioForm(Request $request) {
        $id = $request->post('id');
        $usuario = Usuario::getUsuarioById($id);
        $generos = Usuario::getGeneros();

        $error = session('error');
        return view('gymfit/usuarios/crearUsuarioForm', compact('usuario', 'generos', 'error'));
    }

    public function editarUsuario(Request $request) {
        $id = $request->post('usuario_id');
        $nombre = $request->post('nombre');
        $fecha_nacimiento = $request->post('fecha_nacimiento');
        $email = $request->post('email');
        $genero_id = $request->post('genero_id');
        $password_actual = $request->post('password_actual');
        $password_nueva = $request->post('password_nueva');

        $usuario = Usuario::getUsuarioById($id);
        $passwordDBEncriptada = $usuario->password;
    
        if ($password_nueva) {
            if (session('userInfo')['id'] == $id) {
                if (Hash::check($password_actual, $passwordDBEncriptada)) {
                    // La contraseña ingresada coincide con la contraseña almacenada en la base de datos
    
                    $password_nueva_encriptada =  Hash::make($password_nueva);
                    $usuario = Usuario::updateUsuario($id, $nombre, $fecha_nacimiento, $email, $genero_id, $password_nueva_encriptada);
    
                    // Cerrar sesión
                    if ($usuario) {
                        Auth::guard('usuarios')->logout();
                        $request->session()->forget(['userInfo', 'userType', 'isAdmin', 'isClases', 'isServicios']);
                        $request->session()->invalidate();
                        $request->session()->regenerateToken();
                        return redirect('/login');
                    } else {
                        $error = 'No se ha podido actualizar la contraseña.';
                        return redirect()->route('miPerfilUsuario')->with(['id' => $id, 'error' => $error]);
                    }
                } else {
                    // La contraseña ingresada no coincide con la contraseña almacenada en la base de datos
                    $error = 'La contraseña actual es incorrecta.';
                    return redirect()->route('miPerfilUsuario')->with(['id' => $id, 'error' => $error]);
                }
            } else {
                // No es el usuario del perfil y no puede cambiar la contraseña
                $error = 'No tienes permisos para editar la contraseña de este perfil.';
                return redirect()->route('miPerfilUsuario')->with(['id' => $id, 'error' => $error]);
            }
        } else {
            $usuario = Usuario::updateUsuario($id, $nombre, $fecha_nacimiento, $email, $genero_id, null);
            if (session('userType') == 'usuario') {
                if($usuario) {
                    session('userInfo')['nombre'] = $nombre;
                    session('userInfo')['email'] = $email;
                    session('userInfo')['fecha_nacimiento'] = $fecha_nacimiento;
                    session('userInfo')['genero_id'] = $genero_id;
                    $success='Tu perfil se ha actualizado con éxito.';
                    return redirect()->route('miPerfilUsuario')->with(['id' => $id, 'success' => $success]);
                } else {
                    $error='No se ha podido actualizar tu perfil.';
                    return redirect()->route('miPerfilUsuario')->with(['id' => $id, 'errpr' => $errpr]);
                }
            } else {
                if($usuario) {
                    $success='El usuario se ha actualizado con éxito.';
                    return redirect('/mostrarUsuarios')->with(compact('success'));
                } else {
                    $error='No se ha podido actualizar el usuario.';
                    return redirect('/mostrarUsuarios')->with(compact('error'));
                }
            }
        }
    }

    public function restablecerContraseña(Request $request) {
        $id = $request->post('usuario_id');
        $usuario = Usuario::getUsuarioById($id);
        $usuario_dni = $usuario->dni;

        $password_nueva_encriptada = Hash::make($usuario_dni);
        $usuario = Usuario::updateUsuario($id, $usuario->nombre, $usuario->fecha_nacimiento, $usuario->email, $usuario->genero_id, $password_nueva_encriptada);

        if($usuario) {
            $success='La contraseña se ha restablecido con éxito.';
            return redirect('/mostrarUsuarios')->with(compact('success'));
        } else {
            $error='No se ha podido restablecer al contraseña.';
            return redirect('/mostrarUsuarios')->with(compact('error'));
        }
    }

    public function eliminarUsuarioForm(Request $request) {
        $usuario_id = $request->post('id');
        $usuario = Usuario::getUsuarioById($usuario_id);
        $userType = 'usuario';

        return View::make('modals.modalEliminarUsuario', compact('usuario', 'userType'));
        die();
    }

    public function eliminarUsuario(Request $request) {
        $usuario_id = $request->post('usuario_id');

        $reservasClases = Reserva::getReservasByUsuarioId($usuario_id);
        $reservasServicios = ReservaServicio::getReservasByUsuarioId($usuario_id);

        foreach ($reservasClases as $reserva) {
            $reserva_delete = Reserva::deleteReserva($reserva->id);

            if (!$reserva_delete) {
                $error='No se ha podido eliminar el usuario.';
                return redirect('/mostrarUsuarios')->with(compact('error'));
            }
        }

        foreach ($reservasServicios as $reserva) {
            $reserva_delete = ReservaServicio::deleteReserva($reserva->id);

            if (!$reserva_delete) {
                $error='No se ha podido eliminar el usuario.';
                return redirect('/mostrarUsuarios')->with(compact('error'));
            }
        }

        $usuario = Usuario::deleteUsuario($usuario_id);

        if($usuario) {
            $success='El usuario se ha eliminado correctamente.';
            return redirect('/mostrarUsuarios')->with(compact('success'));
        } else {
            $error='No se ha podido eliminar el usuario.';
            return redirect('/mostrarUsuarios')->with(compact('error'));
        }
    }
}
