<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use Illuminate\Http\Request;
use App\Models\HorarioClases;
use App\Models\Clase;
use App\Models\Sala;
use App\Models\Personal;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Redirect;

class HorariosController extends Controller {
    public function mostrarHorarios() {
        $horarios = Horario::getHorarios();
        return view('gymfit/horario/mostrarHorarios', compact('horarios'));
    }
    
    public function crearHorarioModal(){
        return View::make('modals.modalCrearHorario');
        die();
    }
    
    public function crearHorario(Request $request) {
        $id_horario = Horario::create($request);

        $id_clases_historico = Horario::createHistoricoClases($request, $id_horario);

        $horarios = Horario::getHorarios();

        return Redirect::to('/editarHorarioForm'.'/'.$id_horario);
    }
    
    public function duplicarHorarioModal(Request $request){
        $horario = Horario::find($request->post('id'));
        
        return View::make('modals.modalDuplicarHorario')->with('horario', $horario);
        die();
    }

    public function eliminarHorarioModal(Request $request){
        $horario = Horario::find($request->post('id'));
        
        return View::make('modals.modalEliminarHorario')->with('horario', $horario);
        die();
    }

    public function eliminarHorario(Request $request){
        $id_horario = Horario::eliminar($request->post('horario_id'));
        $horarios = Horario::getHorarios();

        if ($id_horario) {
            $success = 'El horario se ha eliminado con éxito';
            return Redirect::to('/mostrarHorarios')->with('success', $success);
        } else {
            $error = 'El horario no se ha podido eliminar';
            return Redirect::to('/mostrarHorarios')->with('error', $error);
        }
    }
    
    public function duplicarHorario(Request $request) {
        $horario_duplicar_id = $request->input('horario_duplicar_id');
        
        $id_horario = Horario::create($request);
        
        $id_clases_historico = Horario::createHistoricoClases($request, $id_horario);
        
        $clases = HorarioClases::duplicarClasesHorario($horario_duplicar_id, $id_horario);
 
        return Redirect::to('/editarHorarioForm'.'/'.$id_horario);
    }

    public function editarHorarioForm($id) {
        $horario = Horario::getHorarioById($id);
        $clasesHorario = HorarioClases::getClasesHorario($id);
        $diasSemana = Horario::getDiasSemana();
        $franjasHorarias = Horario::getFranjasHorarias();
        $clases = Clase::getAll();
        $salas = Sala::getAll();
        $monitores = Personal::getPersonalByRole('2');

        $error = '';
        $success = '';

        $clasesHorarioOrganizado = [];
        if (!empty($clasesHorario)) {
            foreach ($clasesHorario as $clase) {
                $clasesHorarioOrganizado[$clase->dia_semana_id][$clase->franja_horaria_id][] = $clase;
            }
        }
        return view('gymfit/horario/editarHorarioForm', compact('horario','clasesHorarioOrganizado', 'diasSemana', 'franjasHorarias', 'clases', 'salas' , 'monitores', 'error', 'success'));
    }

    public static function getFechasSemana($inicioSemana) {
        $fechasSemana = [];
        for ($i = 0; $i < 7; $i++) {
            $fecha = $inicioSemana->copy()->addDays($i);
            $fechasSemana[] = [$fecha->format('d/m/Y'), ($fecha->dayOfWeek == 0) ? 7 : $fecha->dayOfWeek];
        }
        return $fechasSemana;
    }

    public function guardarHorario () {
        $horarios = Horario::getHorarios();
        return view('gymfit/horario/mostrarHorarios', compact('horarios'));
    }
}

?>