<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller; 

class UsuariosController extends Controller {
    public function mostrarUsuarios() {
        $usuarios = Usuario::getAll();
        return view('gymfit/usuarios/mostrarUsuarios', compact('usuarios'));
    }

    public function crearUsuarioForm() {
        $generos = Usuario::getGeneros();
        return view('gymfit/usuarios/crearUsuarioForm', compact('generos'));
    }

    public function crearUsuario(Request $request) {
        $id_usuario = Usuario::create($request);
        return Redirect::to('/mostrarUsuarios');
    }
}
