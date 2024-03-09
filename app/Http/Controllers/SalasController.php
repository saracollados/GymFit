<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sala;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller; 

class SalasController extends Controller {
    public function mostrarSalas() {
        $salas = Sala::getAll();
        return view('gymfit/salas/mostrarSalas', compact('salas'));
    }

    public function crearSalaForm() {
        return view('gymfit/salas/crearSalaForm');
    }

    public function crearSala(Request $request) {
        $id_sala = Sala::create($request);
        return Redirect::to('/mostrarSalas');
    }
}
