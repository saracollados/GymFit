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
use Carbon\Carbon;

use Illuminate\Support\Facades\Log;

class HorariosController extends Controller {
    public function mostrarHorarios() {
        $horarios = Horario::getHorarios();

        foreach($horarios as &$horario) {
            $periodo_validez = $this->periodosValidezHorarios($horario->id);
            $horario->periodosValidez = $periodo_validez;
        }

        return view('gymfit/horario/mostrarHorarios', compact('horarios'));
    }

    public function periodosValidezHorarios($horario_id) {
        $fechas_horario = Horario::getFechasHorario($horario_id);

        $periodosValidez = [];
        $inicio = null;
        $fin = null;

        foreach ($fechas_horario as $registro) {
            $fecha = Carbon::parse($registro->fecha);
            if ($inicio === null) {
                $inicio = $fecha;
                $fin = $fecha;
            } elseif ($fecha->diffInDays($fin) === 1) {
                $fin = $fecha;
            } else {
                $periodosValidez[] = [$inicio->format('d-m-Y'), $fin->format('d-m-Y')];
                $inicio = $fecha;
                $fin = $fecha;
            }
        }

        if ($inicio !== null) {
            $periodosValidez[] = [$inicio->format('d-m-Y'), $fin->format('d-m-Y')];
        }

        return $periodosValidez;
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
        $horario_id = $request->post('horario_id'); 
        $periodo_validez = $this->periodosValidezHorarios($horario_id);
        
        
        if ($periodo_validez != []) {
            $error = 'No se puede eliminar un horario con fechas asignadas.';
            return Redirect::to('/mostrarHorarios')->with('error', $error);
        } else {
            $horario_id = Horario::eliminar($request->post('horario_id'));
            
            if ($horario_id) {
                $success = 'El horario se ha eliminado con éxito.';
                return Redirect::to('/mostrarHorarios')->with('success', $success);
            } else {
                $error = 'El horario no se ha podido eliminar.';
                return Redirect::to('/mostrarHorarios')->with('error', $error);
            }
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