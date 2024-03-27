<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clase;
use App\Models\Horario;
use App\Models\HorarioClases;
use App\Http\Controllers\HorariosController; 
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View; 

class ClasesController extends Controller {
    public function mostrarClases() {
        $clases = Clase::getAll();

        $success = session('success');
        $error = session('error');

        return view('gymfit/clases/mostrarClases', compact('clases', 'success', 'error'));
    }

    public function crearClaseForm() {
        return view('gymfit/clases/crearClaseForm');
    }

    public function crearClase(Request $request) {
        $nombre = $request->input('nombre');
        $descripcion = $request->input('descripcion');
        $color = $request->input('color');
        $id_clase = Clase::create($nombre, $descripcion, $color);

        if($id_clase) {
            $success='La clase se ha creado con éxito.';
            return redirect('/mostrarClases')->with(compact('success'));
        } else {
            $success='No se ha podido crear al clase.';
            return redirect('/mostrarClases')->with(compact('error'));
        }
    }

    public function editarClaseForm($id) {
        $clase = Clase::getClaseById($id);

        return view('gymfit/clases/crearClaseForm', compact('clase'));
    }

    public function editarClase(Request $request) {
        $id = $request->post('clase_id');
        $nombre = $request->input('nombre');
        $descripcion = $request->input('descripcion');
        $color = $request->input('color');

        $clase = Clase::updateClase($id, $nombre, $descripcion, $color);

        if($clase) {
            $success='La clase se ha actualizado con éxito.';
            return redirect('/mostrarClases')->with(compact('success'));
        } else {
            $error='No se ha podido actualizar la clase.';
            return redirect('/mostrarClases')->with(compact('error'));
        }
    }
    
    public function eliminarClaseForm(Request $request) {
        $clase_id = $request->post('id');
        $clase = Clase::getClaseById($clase_id);

        return View::make('modals.modalEliminarClase', compact('clase'));
        die();
    }

    public function eliminarClase(Request $request) {
        $clase_id = $request->post('clase_id');

        $horarios = Horario::getHorarios();

        foreach($horarios as $horario) {

            $periodo_validez = HorariosController::periodosValidezHorarios($horario->id);

            if (count($periodo_validez) > 0) {
                $clasesHorario = HorarioClases::getClasesHorario($horario->id, null, null, $clase_id);

                if (count($clasesHorario) > 0) {
                    $error='No se ha podido eliminar la clase esta asignada en horarios activos. Actualice los horarios antes de eliminar la clase.';
                    return redirect('/mostrarClases')->with(compact('error'));
                }
                    
            }
        }

        $clase = Clase::deleteClase($clase_id);

        if($clase) {
            $success='La clase se ha eliminado con éxito.';
            return redirect('/mostrarClases')->with(compact('success'));
        } else {
            $error='No se ha podido eliminar la clase.';
            return redirect('/mostrarClases')->with(compact('error'));
        }
    }
}

?>