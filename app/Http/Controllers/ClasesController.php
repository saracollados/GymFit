<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clase;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller; 

class ClasesController extends Controller {
    public function mostrarClases() {
        $clases = Clase::getAll();
        return view('gymfit/clases/mostrarClases', compact('clases'));
    }

    public function crearClaseForm() {
        return view('gymfit/clases/crearClaseForm');
    }

    public function crearClase(Request $request) {
        $id_clase = Clase::create($request);
        return Redirect::to('/mostrarClases');
    }
}

?>