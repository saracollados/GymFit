<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Horario;
use App\Models\Usuario;
use App\Models\Sala;
use App\Models\HorarioClases;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;

class ReservasController extends Controller {
    public function mostrarReservasClases(Request $request) {
        $usuarioInfo = session('userInfo');
        $usuarioTipo = session('userType');

        if ($usuarioTipo == 'usuario' || $usuarioTipo == 'personal' && $usuarioInfo['role_id'] != 1) {
            $reservasClases = Reserva::getReservasClases($usuarioInfo['id']);
        } else {
            $reservasClases = Reserva::getReservasClases();
        }

        foreach ($reservasClases as &$reserva) {
            $reserva->pasada = ReservasController::isClasePasada($reserva->fecha, $reserva->franja_horaria_nombre);
        }

        return view('gymfit/reservas/mostrarReservasClases', compact('reservasClases', 'usuarioInfo'));
    }

    public function mostrarReservasServicios() {
        $reservasServicios = Reserva::getReservasServicios();
        return view('gymfit/reservas/mostrarReservasServicios', compact('reservasServicios'));
    }

    public function usuarioReservaModal(){
        return View::make('modals.modalUsuarioReserva');
        die();
    }

    public function reservaClaseForm(Request $request){
        $usuario_id = $request->post('usuario_id');
        $usuario = Usuario::getUsuarioById($usuario_id);
        $clase = $request->post('clase');
        $reserva = $request->post('reserva');

        return View::make('modals.modalCrearReserva', compact('usuario_id', 'clase', 'usuario', 'reserva'));
        die();
    }

    public function crearReservaClaseForm(Request $request, $success=null, $error=null) {
        $usuario_dni = $request->post('dni');

        $usuario = Usuario::where('dni', $usuario_dni)->first();

        if(!$usuario) {
            $reservasClases = Reserva::getReservasClases();
            $error = 'Ese usuario no existe';

            return view('gymfit/reservas/mostrarReservasClases', compact('reservasClases', 'error'));
        } else {
            Carbon::setWeekStartsAt(Carbon::MONDAY);
    
            $diasSemana = Horario::getDiasSemana();
            $franjasHorarias = Horario::getFranjasHorarias();
    
            $hoy = Carbon::now()->format('d/m/Y');
    
            $inicioSemanaActual = Carbon::createFromFormat('d/m/Y', $hoy)->startOfWeek();
    
            // Calcula las fechas de la semana actual
            $fechasSemanaActual = [];
            for ($i = 0; $i < 7; $i++) {
                $fecha = $inicioSemanaActual->copy()->addDays($i);
                $fechasSemanaActual[] = [$fecha->format('d/m/Y'), ($fecha->dayOfWeek == 0) ? 7 : $fecha->dayOfWeek];
            }
    
            // Calcula las fechas de la semana siguiente
            $inicioSemanaSiguiente = Carbon::createFromFormat('d/m/Y', $hoy)->addWeek()->startOfWeek();
            $fechasSemanaSiguiente = [];
            for ($i = 0; $i < 7; $i++) {
                $fecha = $inicioSemanaSiguiente->copy()->addDays($i);
                $fechasSemanaSiguiente[] = [$fecha->format('d/m/Y'), ($fecha->dayOfWeek == 0) ? 7 : $fecha->dayOfWeek];
            }
    
            $clasesSemanaActual = ReservasController::getClasesSemanaUsuario($fechasSemanaActual, $usuario->id);
            $clasesSemanaSiguiente = ReservasController::getClasesSemanaUsuario($fechasSemanaSiguiente, $usuario->id);

            foreach ($fechasSemanaActual as &$fecha) {
                $diaSemana = Horario::getDiaSemanaById($fecha[1]);
                $diaSemana = $diaSemana;
                $fecha[] = $diaSemana;
            }

            if (isset($error)) {
                return view('gymfit/reservas/crearReservaClaseForm', compact('clasesSemanaActual', 'clasesSemanaSiguiente','fechasSemanaActual', 'franjasHorarias', 'usuario', 'error'));
            } elseif (isset($success)) {
                return view('gymfit/reservas/crearReservaClaseForm', compact('clasesSemanaActual', 'clasesSemanaSiguiente','fechasSemanaActual', 'franjasHorarias', 'usuario', 'success'));
            } else {
                return view('gymfit/reservas/crearReservaClaseForm', compact('clasesSemanaActual', 'clasesSemanaSiguiente','fechasSemanaActual', 'franjasHorarias', 'usuario'));
            }
    
        }

    }

    public function getClasesSemanaUsuario($array_fechas, $usuario_id) {
        $clasesSemana = collect();

        foreach ($array_fechas as $fecha_array) {
            $fecha_formato = Carbon::createFromFormat('d/m/Y', $fecha_array[0])->format('Y-m-d');
            $horario_id_collection = DB::table('clases_historico')->where('fecha', $fecha_formato)->get('horario_id');
            $fecha_id = DB::table('clases_historico')->where('fecha', $fecha_formato)->get('id')->first()->id;
            $dia_semana_id = $fecha_array[1];
            $fecha = $fecha_array[0];
            $fecha_clase = [
                'fecha' => $fecha,
                'fecha_formato' => $fecha_formato,
                'fecha_id' => $fecha_id,
                'dia_semana_id' => $dia_semana_id
            ];

            if ($horario_id_collection->isNotEmpty()) {
                $horario_id = $horario_id_collection->first()->horario_id;
            } else {
                /* ------------------------------------------
                    ¿QUÉ PASA SI EL HORARIO ES NULL?
                -------------------------------------------*/
                $horario_id = null;
            }

            
            $clasesDia = HorarioClases::getClasesByHorarioDia($horario_id, $dia_semana_id);

            foreach($clasesDia as &$clase) {
                $clase->fecha = $fecha_clase;

                $plazas_totales = Sala::getAforo($clase->sala_id);
                $plazas_ocupadas = Reserva::getPlazasOcupadas($clase->id, $clase->fecha['fecha_id']);
                $plazas_libres = $plazas_totales - $plazas_ocupadas;
                $plazas = [
                    'total' => $plazas_totales,
                    'ocupadas' => $plazas_ocupadas,
                    'libres' => $plazas_libres
                ];

                $clase->plazas = $plazas;

                $reserva_id = Reserva::getReservaId($usuario_id, $clase->id, $clase->fecha['fecha_id']);
                $clase->reserva_id = $reserva_id;

                // Verificar si la clase ya ha pasado
                $clase->pasada = ReservasController::isClasePasada($fecha_formato, $clase->franja_horaria_nombre);
            }

            $clasesSemana = $clasesSemana->concat($clasesDia);

            $clasesHorarioOrganizado = [];
            foreach ($clasesSemana as $clase) {
                $clasesHorarioOrganizado[$clase->dia_semana_id][$clase->franja_horaria_id][] = $clase;
            }
        }

        return $clasesHorarioOrganizado;
    }

    public function isClasePasada($fecha_clase, $franja_horaria_clase) {
        $fecha_actual = Carbon::now()->startOfDay();
        $hora_actual = Carbon::now()->startOfHour()->format('H');
        $hora_clase_inicio_str = explode('-', $franja_horaria_clase)[0];
        $hora_clase_inicio = Carbon::createFromFormat('H', $hora_clase_inicio_str)->format('H');


        $fecha_clase = Carbon::createFromFormat('Y-m-d', $fecha_clase)->startOfDay();

        if ($fecha_actual->gt($fecha_clase)) {
            return true;
        } elseif($fecha_actual->eq($fecha_clase)) {
            if ($hora_actual >= $hora_clase_inicio) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function crearReservaClase(Request $request) {
        $usuario_id = $request->input('usuario_id');
        $clase_id = $request->input('clase_id'); 
        $fecha_id = $request->input('fecha_id');
        $franja_horaria_id = $request->input('franja_horaria_id');

        $reserva_id = Reserva::getReservaId($usuario_id, $clase_id, $fecha_id);
        $existeReservaHora = Reserva::existeReservaHora($usuario_id, $fecha_id, $franja_horaria_id);

        if($reserva_id) {
            $error = 'El usuario ya tiene reservada esta clase.';
            return $this->crearReservaClaseForm($request, null, $error);
        }

        if($existeReservaHora) {
            $error = 'El usuario ya tiene reservada una clase a esa hora.';
            return $this->crearReservaClaseForm($request, null, $error);
        }

        $id_reserva = Reserva::create($request);

        if ($id_reserva) {
            $success = 'La reserva se ha realizado con éxito.';
            return $this->crearReservaClaseForm($request, $success, null);
        } else {
            $error = 'No se ha podido realizar la reserva.';
            return $this->crearReservaClaseForm($request, null, $error);
        }
    }

    public function eliminarReservaClase(Request $request) {
        $usuario_id = $request->input('usuario_id');
        $clase_id = $request->input('clase_id'); 
        $fecha_id = $request->input('fecha_id');

        $usuario = Usuario::getUsuarioById($usuario_id);
        $nuevoRequest = ['dni' => $usuario->dni];
        $request->merge($nuevoRequest);

        $reserva_id = Reserva::getReservaId($usuario_id, $clase_id, $fecha_id);
        
        if ($reserva_id) {
            $reserva_id = $reserva_id['id'];
            Reserva::deleteReserva($reserva_id);
            $success = 'La reserva se ha eliminado con éxito.';
            return $this->crearReservaClaseForm($request, $success, null);
        } else {
            $error = 'No se ha podido eliminar la reserva.';
            return $this->crearReservaClaseForm($request, null, $error);
        }
    }
}
