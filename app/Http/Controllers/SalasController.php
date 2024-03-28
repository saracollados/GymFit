<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sala;
use App\Models\Horario;
use App\Models\HorarioClases;
use App\Http\Controllers\HorariosController; 
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\View; 

class SalasController extends Controller {
    public function mostrarSalas() {
        $salas = Sala::getAll();

        $success = session('success');
        $error = session('error');

        return view('gymfit/salas/mostrarSalas', compact('salas', 'success', 'error'));
    }

    public function crearSalaForm() {
        return view('gymfit/salas/crearSalaForm');
    }

    public function crearSala(Request $request) {
        $id_sala = Sala::create($request);

        if($id_sala) {
            $success='La sala se ha creado con éxito.';
            return redirect('/mostrarSalas')->with(compact('success'));
        } else {
            $error='No se ha podido crear la sala.';
            return redirect('/mostrarSalas')->with(compact('error'));
        }
    }

    public function editarSalaForm($id) {
        $sala = Sala::getSalaById($id);

        return view('gymfit/salas/crearSalaForm', compact('sala'));
    }

    public function editarSala(Request $request) {
        $id = $request->post('sala_id');
        $nombre = $request->input('nombre');
        $aforo = $request->input('aforo');

        $sala = Sala::updateSala($id, $nombre, $aforo);

        if($sala) {
            $success='La clase se ha actualizado con éxito.';
            return redirect('/mostrarSalas')->with(compact('success'));
        } else {
            $error='No se ha podido actualizar la clase.';
            return redirect('/mostrarSalas')->with(compact('error'));
        }
    }

    public function eliminarSalaForm(Request $request) {
        $sala_id = $request->post('id');
        $sala = Sala::getSalaById($sala_id);

        return View::make('modals.modalEliminarSala', compact('sala'));
        die();
    }

    public function eliminarSala(Request $request) {
        $sala_id = $request->post('sala_id');

        $horarios = Horario::getHorarios();

        foreach($horarios as $horario) {

            $periodo_validez = HorariosController::periodosValidezHorarios($horario->id);

            if (count($periodo_validez) > 0) {
                $clasesHorario = HorarioClases::getClasesHorario($horario->id, null, $sala_id);

                if (count($clasesHorario) > 0) {
                    $error='No se ha podido eliminar la sala ya que tiene clases asignadas en horarios activos. Actualice los horarios antes de eliminar la sala.';
                    return redirect('/mostrarSalas')->with(compact('error'));
                }
                    
            }
        }

        $sala = Sala::deleteSala($sala_id);

        if($sala) {
            $success='La sala se ha eliminado con éxito.';
            return redirect('/mostrarSalas')->with(compact('success'));
        } else {
            $error='No se ha podido eliminar la sala.';
            return redirect('/mostrarSalas')->with(compact('error'));
        }
    }
}
