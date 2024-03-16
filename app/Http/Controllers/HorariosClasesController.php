<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clase;
use App\Models\Sala;
use App\Models\Personal;
use App\Models\Horario;
use App\Models\HorarioClases;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller; 

class HorariosClasesController extends Controller {
    public function mostrarClasesHorario($id) {
        $clasesHorario = HorarioClases::getClasesHorario($id);
        $diasSemana = Horario::getDiasSemana();
        $franjasHorarias = Horario::getFranjasHorarias();
        $horario = Horario::find($id);

        $clasesHorarioOrganizado = [];
        foreach ($clasesHorario as $clase) {
            $clasesHorarioOrganizado[$clase->dia_semana_id][$clase->franja_horaria_id][] = $clase;
        }
        return view('gymfit/horario/mostrarHorarioClases', compact('clasesHorarioOrganizado', 'diasSemana', 'franjasHorarias', 'horario'));
    }

    public function crearHorarioForm() {
        $clases = Clase::getAll();
        $salas = Sala::getAll();
        $monitores = Personal::getPersonalByRole('2');
        $franjasHorarias = Horario::getFranjasHorarias();
        $diasSemana = Horario::getDiasSemana();
        return view('gymfit/horario/crearHorarioForm', compact('clases', 'salas', 'monitores', 'franjasHorarias', 'diasSemana'));
    }

    public function crearClaseHorario(Request $request) {
        $claseRequest = $request['clase_id'];
        $monitorRequest = $request['monitor_id'];
        $dia_semanaRequest = $request['dia_semana_id'];
        $franja_horariaRequest = $request['franja_horaria_id'];
        $salaRequest = $request['sala_id'];
        $horarioRequest = $request['horario_id'];

        $clasesHorario = HorarioClases::getClasesHorario($horarioRequest);

        foreach ($clasesHorario as $claseHorario) {
            $monitorDB = $claseHorario['monitor_id'];
            $salaDB = $claseHorario['sala_id'];
            $dia_semanaDB = $claseHorario['dia_semana_id'];
            $franja_horariaDB = $claseHorario['franja_horaria_id'];
            $claseDB = $claseHorario['clase_id'];
            $horarioDB = $request['horario_id'];

            $stringSalaRequest = $salaRequest.$dia_semanaRequest.$franja_horariaRequest.$horarioRequest;
            $stringSalaDB = $salaDB.$dia_semanaDB.$franja_horariaDB.$horarioDB;
           
            $stringMonitorRequest = $monitorRequest.$dia_semanaRequest.$franja_horariaRequest.$horarioRequest;
            $stringMonitorDB = $monitorDB.$dia_semanaDB.$franja_horariaDB.$horarioDB;
            
            $stringClaseRequest = $claseRequest.$dia_semanaRequest.$franja_horariaRequest.$horarioRequest;
            $stringClaseDB = $claseDB.$dia_semanaDB.$franja_horariaDB.$horarioDB;

            if ($stringSalaRequest == $stringSalaDB || $stringMonitorRequest == $stringMonitorDB || $stringClaseRequest == $stringClaseDB) {
                if ($stringSalaRequest == $stringSalaDB) {                  // Comprobación de que no se crea una clase en una sala ocupada             
                    $error = 'Ya existe una clase a esa hora en esa sala.';
                } 
                if ($stringMonitorRequest == $stringMonitorDB) {      // Comprobación de que no se crea una clase con un monitor ocupado
                    $error = 'Ese monitor ya tiene una clase a esa hora.';
                } 
                if ($stringClaseRequest == $stringClaseDB) {          // Comprobación de que no se crea la misma clase a la misma hora
                    $error = 'Ya existe esa clase a esa hora.';
                }

                return Redirect::to('/editarHorarioForm'.'/'.$horarioRequest)->with('error', $error);
            }
        }
        
        $success = 'La clase se ha añadido con éxito.';
        $id_clase = HorarioClases::create($request);
        return Redirect::to('/editarHorarioForm'.'/'.$horarioRequest)->with('success', $success);
    }

    public function eliminarClaseHorarioModal(Request $request) {
        $clase = HorarioClases::getClaseById($request->post('id'));

        return View::make('modals.modalEliminarClaseHorario')->with('clase', $clase);
        die();
    }

    public function eliminarClaseHorario(Request $request) {
        $id_horario = $request->post('horario_id');
        $id_clase = HorarioClases::eliminarClase($request->post('clase_id'));

        if ($id_clase) {
            $success = 'La clase se ha eliminado con éxito';
            return Redirect::to('/editarHorarioForm'.'/'.$id_horario)->with('success', $success);
        } else {
            $error = 'La clase no se ha podido eliminar';
            return Redirect::to('/editarHorarioForm'.'/'.$id_horario)->with('error', $error);
        }
    }
}
