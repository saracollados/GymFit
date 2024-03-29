<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use Illuminate\Http\Request;
use App\Models\HorarioClases;
use App\Models\Clase;
use App\Models\Sala;
use App\Models\Reserva;
use App\Models\Personal;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class HorariosController extends Controller {
    public function mostrarHorarios() {
        $horarios = Horario::getHorarios();

        foreach($horarios as &$horario) {
            $periodo_validez = $this->periodosValidezHorarios($horario->id);
            $horario->periodosValidez = $periodo_validez;
        }

        $success = session('success');
        $error = session('error');

        return view('gymfit/horario/mostrarHorarios', compact('horarios', 'success', 'error'));
    }

    public static function periodosValidezHorarios($horario_id) {
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
        $nombre = $request->input('nombre');
        $fecha_desde = $request->input('fecha_desde');
        $fecha_hasta = $request->input('fecha_hasta');

        $fechas_periodo = $this->getFechasPeriodo($fecha_desde, $fecha_hasta);

        if (is_string($fechas_periodo)) {
            return redirect('/mostrarHorarios')->with('error', $fechas_periodo);
        }

        $horario_id = Horario::create($nombre);

        if(!$horario_id ) {
            $error = 'No se ha podido crear el horario.';
            return redirect('/mostrarHorarios')->with('error', $error);
        }

        $fechas_horario = $this->actualizarFechasHorario($horario_id, $fechas_periodo);

        if ($fechas_horario !== true) {
            return redirect('/mostrarHorarios')->with('error', $fechas_horario);
        }

        $horarios = Horario::getHorarios();

        return Redirect::to('/editarHorarioForm'.'/'.$horario_id);
    }
    
    public function duplicarHorarioModal(Request $request){
        $horario = Horario::find($request->post('id'));
        
        return View::make('modals.modalDuplicarHorario')->with('horario', $horario);
        die();
    }
    
    public function duplicarHorario(Request $request) {
        $horario_duplicar_id = $request->input('horario_duplicar_id');
        $nombre = $request->input('nombre');
        $fecha_desde = $request->input('fecha_desde');
        $fecha_hasta = $request->input('fecha_hasta');
        
        $id_horario = Horario::create($nombre);

        if (!$id_horario) {
            $error = 'No se ha podido crear el horario.';
            return redirect('/mostrarHorarios')->with('error', $error);
        }

        $id_clases_historico = Horario::createHistoricoClases($id_horario, $fecha_desde, $fecha_hasta);
        
        if (!$id_clases_historico) {
            $error = 'No se ha podido asignar el periodo de validez indicado debido a que no se pueden modificar fechas pasadas.';
            return redirect('/mostrarHorarios')->with('error', $error);
        }
        
        $clases = HorarioClases::duplicarClasesHorario($horario_duplicar_id, $id_horario);
 
        return Redirect::to('/editarHorarioForm'.'/'.$id_horario);
    }

    public function editarHorarioModal(Request $request){
        $horario = Horario::find($request->post('id'));
        
        return View::make('modals.modalEditarHorario')->with('horario', $horario);
        die();
    }

    public function editarHorario(Request $request) {
        $horario_id = $request->input('horario_id');
        $nombre = $request->input('nombre');
        $fecha_desde = $request->input('fecha_desde');
        $fecha_hasta = $request->input('fecha_hasta');

        if ($fecha_desde && $fecha_hasta) {
            $fechas_periodo = $this->getFechasPeriodo($fecha_desde, $fecha_hasta);
    
            if (is_string($fechas_periodo)) {
                return redirect('/mostrarHorarios')->with('error', $fechas_periodo);
            }
    
            $fechas_horario = $this->actualizarFechasHorario($horario_id, $fechas_periodo);
    
            if ($fechas_horario !== true) {
                return redirect('/mostrarHorarios')->with('error', $fechas_horario);
            }
        } elseif ($fecha_desde || $fecha_hasta) {
            $error = 'No se puede cumplementar únicamente una de las fechas.';
            return redirect('/mostrarHorarios')->with('error', $error);
        }


        $horario = Horario::editarNombreHorario($horario_id, $nombre);

        if ($horario) {
            $success = 'El horario se ha actualizado con éxito.';
            return redirect('/mostrarHorarios')->with('success', $success);
        } else {
            $error = 'No se ha podido actualizar el horario.';
            return redirect('/mostrarHorarios')->with('error', $error);
        }
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

    public function eliminarHorarioModal(Request $request){
        $horario = Horario::find($request->post('id'));
        
        return View::make('modals.modalEliminarHorario')->with('horario', $horario);
        die();
    }

    public function eliminarHorario(Request $request){
        $horario_id = $request->post('horario_id');

        $fechas_horario = Horario::getFechasHorario($horario_id);

        
        foreach ($fechas_horario as $fecha_object) {
            $fecha = Carbon::createFromFormat('Y-m-d', $fecha_object->fecha);
            if ($fecha->isPast()) {
                $error = 'El horario contiene fechas de validez pasadas que no se pueden eliminar.';
                return redirect('/mostrarHorarios')->with('error', $error);
            }
        }

        $horario_delete = Horario::eliminar($horario_id);
        
        if ($horario_delete) {
            $success = 'El horario se ha eliminado con éxito.';
            return redirect('/mostrarHorarios')->with('success', $success);
        } else {
            $error = 'El horario no se ha podido eliminar.';
            return redirect('/mostrarHorarios')->with('error', $error);
        }
    }

    public function getFechasPeriodo($fecha_desde, $fecha_hasta) {
        $fecha_desde = Carbon::createFromFormat('Y-m-d', $fecha_desde);
        $fecha_hasta = Carbon::createFromFormat('Y-m-d', $fecha_hasta);

        if (!$fecha_desde || !$fecha_hasta) {
            $error = 'Las fechas proporcionadas son inválidas.';
            return $error;
        }
    
        if ($fecha_desde->greaterThanOrEqualTo($fecha_hasta)) {
            $error = 'La fecha de inicio debe ser anterior a la fecha de fin.';
            return $error;
        }

        if ($fecha_desde->isPast()) {
            $error = 'El periodo incluye fechas pasadas.';
            return $error;
        }

        $periodo = Carbon::parse($fecha_desde)->daysUntil($fecha_hasta);

        $fechas_entre = $periodo->map(function ($fecha) {
            return $fecha->format('Y-m-d');
        });

        return $fechas_entre;
    }

    public function actualizarFechasHorario ($horario_id, $periodo) {
        foreach ($periodo as $fecha) {
            $existe_fecha = Horario::existeFecha($fecha);
            
            if ($existe_fecha) {
                $actualizacion_fecha = Horario::actualizarFecha($horario_id, $fecha);

                // Si el horario ha cambiado, se eliminan todas las reservas para esa fecha
                if ($actualizacion_fecha) {
                    $fecha_object = Horario::getFechaId($fecha);
                    $fecha_id = $fecha_object->id;

                    $reservas = Reserva::getReservasByFechaId($fecha_id);

                    foreach($reservas as $reserva) {
                        $reserva_delete = Reserva::deleteReserva($reserva->id);
                    }
                }
            } else {
                $fecha_id = Horario::crearFecha($horario_id, $fecha);
            }
        }
        return true;
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
        $success = 'El horario se ha creado con éxito.';
        return redirect('/mostrarHorarios')->with('success', $success);
    }
}

?>