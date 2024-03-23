<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsuariosController extends Controller {
    public function mostrarUsuarios() {
        $usuarios = Usuario::getAll();

        $success = session('success');
        $error = session('error');

        return view('gymfit/usuarios/mostrarUsuarios', compact('usuarios', 'success', 'error'));
    }

    public function crearUsuarioForm() {
        $generos = Usuario::getGeneros();
        return view('gymfit/usuarios/crearUsuarioForm', compact('generos'));
    }

    public function crearUsuario(Request $request) {
        $id_usuario = Usuario::create($request);
        return Redirect::to('/mostrarUsuarios');
    }

    public function editarUsuarioForm($id) {
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
            $password_actual_hash =  Hash::make($password_actual);
            if (Hash::check($password_actual, $passwordDBEncriptada)) {
                $password_nueva_encriptada =  Hash::make($password_nueva);
                // La contraseña ingresada coincide con la contraseña almacenada en la base de datos
                $usuario = Usuario::updateUsuario($id, $nombre, $fecha_nacimiento, $email, $genero_id, $password_nueva_encriptada);
            } else {
                // La contraseña ingresada no coincide con la contraseña almacenada en la base de datos
                $error = 'La contraseña actual es incorrecta.';
                return redirect()->route('editarUsuario', ['id' => $id])->with('error', $error);
            }
        } else {
            $usuario = Usuario::updateUsuario($id, $nombre, $fecha_nacimiento, $email, $genero_id, null);
        }

        if($usuario) {
            $success='El usuario se ha actualizado con éxito.';
            return redirect('/mostrarUsuarios')->with(compact('success'));
        } else {
            $error='No se ha podido actualizar el usuario.';
            return redirect('/mostrarUsuarios')->with(compact('error'));
        }
    }

    public function eliminarUsuarioForm(Request $request) {
        $usuario_id = $request->post('id');
        $usuario = Usuario::getUsuarioById($usuario_id);

        return View::make('modals.modalEliminarUsuario', compact('usuario'));
        die();
    }

    public function eliminarUsuario(Request $request) {
        $usuario_id = $request->post('usuario_id');
        Log::error($usuario_id);
        $usuario = Usuario::deleteUsuario($usuario_id);

        if($usuario) {
            $success='El usuario se ha eliminado con éxito.';
            return redirect('/mostrarUsuarios')->with(compact('success'));
        } else {
            $error='No se ha podido eliminar el usuario.';
            return redirect('/mostrarUsuarios')->with(compact('error'));
        }
    }
}
