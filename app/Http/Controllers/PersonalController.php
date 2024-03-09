<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Clase;
use App\Models\Sala;
use App\Models\Personal;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller; 

class PersonalController extends Controller {
    public function mostrarDashboard() {
        $usuarios = Usuario::getAll();
        $salas = Sala::getAll();
        $clases = Clase::getAll();
        return view('gymfit/dashboard', compact('usuarios', 'salas', 'clases'));
    }

    public function mostrarPersonal() {
        $personal = Personal::getAll();
        return view('gymfit/personal/mostrarPersonal', compact('personal'));
    }

    public function crearPersonalForm() {
        return view('gymfit/personal/crearPersonalForm');
    }

    public function crearPersonal(Request $request) {
        $id_personal = Personal::create($request);
        return Redirect::to('/mostrarPersonal');
    }
}
