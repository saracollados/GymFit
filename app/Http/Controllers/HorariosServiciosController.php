<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personal;
use App\Models\Horario;
use App\Models\Reserva;
use App\Models\ReservaServicio;
use App\Models\HorarioServicios;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller; 
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

class HorariosServiciosController extends Controller {
    public function mostrarHorariosServicios(Request $request) {
        $diasSemana = Horario::getDiasSemana();
        $franjasHorarias = Horario::getFranjasHorarias();
        $profesionales = Personal::getPersonalByRole('3', '4');
        
        $error = '';
        $success = '';
        
        if (session('inicioSemana')) {
            $inicioSemana = session('inicioSemana');
        } elseif ($request->input('inicioSemana')) {
            $inicioSemana = $request->input('inicioSemana');
        }
        
        if (isset($inicioSemana)) {
            $inicioSemanaActual = Carbon::createFromFormat('d/m/Y', $inicioSemana)->startOfWeek();
        } else {
            $hoy = Carbon::now()->format('d/m/Y');
            $inicioSemanaActual = Carbon::createFromFormat('d/m/Y', $hoy)->startOfWeek();
        }

        // Calcula las fechas de la semana actual
        $fechasSemanaActual = HorariosController::getFechasSemana($inicioSemanaActual);

        // Calcula las fechas de la semana siguiente
        $inicioSemanaActual = Carbon::parse($inicioSemanaActual)->startOfWeek();
        $inicioSemanaSiguiente = $inicioSemanaActual->copy()->addWeek()->startOfWeek();
        $fechasSemanaSiguiente = HorariosController::getFechasSemana($inicioSemanaSiguiente);
        
        // Calcula las fechas de la semana anterior
        $inicioSemanaAnterior = $inicioSemanaActual->copy()->subWeek()->startOfWeek();
        $fechasSemanaAnterior = HorariosController::getFechasSemana($inicioSemanaAnterior);

        $usuarioInfo = session('userInfo');
        $usuarioTipo = session('userType');

        if ($usuarioTipo == 'usuario'){
            $reservasServicios = ReservaServicio::getReservasServicios($usuarioInfo['id']);
            $serviciosSemanaActual = HorariosServiciosController::getServiciosSemana($fechasSemanaActual, $usuarioInfo['id'], null);
        } elseif ($usuarioTipo == 'personal' && $usuarioInfo['role_id'] != 1) {
            $reservasServicios = ReservaServicio::getReservasServicios($usuarioInfo['id']);
            $serviciosSemanaActual = HorariosServiciosController::getServiciosSemana($fechasSemanaActual, null, $usuarioInfo['id']);
        } else {
            $reservasServicios = ReservaServicio::getReservasServicios();
            $serviciosSemanaActual = HorariosServiciosController::getServiciosSemana($fechasSemanaActual);
        }


        foreach ($fechasSemanaActual as &$fecha) {
            $diaSemana = Horario::getDiaSemanaById($fecha[1]);
            $diaSemana = $diaSemana;
            $fecha[] = $diaSemana;
        }

        return view('gymfit/horario/mostrarHorarioServicios', compact('serviciosSemanaActual', 'diasSemana', 'fechasSemanaActual', 'fechasSemanaSiguiente', 'fechasSemanaAnterior', 'franjasHorarias', 'profesionales', 'error', 'success'));
    }

    public function crearServicioHorario(Request $request) {
        $profesional_id = $request['profesional_id'];
        $fecha = $request['fecha'];
        $franja_horaria_id = $request['franja_horaria_id'];
        $fechaInicio = $request->input('fechaInicioSemana');

        $existeServicio = HorarioServicios::existeServicio($profesional_id, $fecha, $franja_horaria_id);

        $franja_horaria_nombre = Horario::getFranjaHorariaById($franja_horaria_id)->nombre;
        $isPasada = ReservasController::isClasePasada($fecha, $franja_horaria_nombre);

        $diasSemana = Horario::getDiasSemana();
        $franjasHorarias = Horario::getFranjasHorarias();
        $profesionales = Personal::getPersonalByRole('3', '4');

        $success = '';
        $error = '';

        if ($existeServicio) {
            if (session('isServicios')) {
                $error = 'Ya tienes un servicio a esa hora.';
                return Redirect::to('/mostrarHorariosServicios')->with(['error' => $error, 'inicioSemana' => $fechaInicio]);
            } else {
                $error = 'Ese profesional ya tiene un servicio a esa hora.';
                return Redirect::to('/mostrarHorariosServicios')->with(['error' => $error, 'inicioSemana' => $fechaInicio]);
            }
        } elseif ($isPasada) {
            $error = 'No se pueden crear servicios pasados.';
            return Redirect::to('/mostrarHorariosServicios')->with(['error' => $error, 'inicioSemana' => $fechaInicio]);
        } else {
            $id_servicio = HorarioServicios::create($profesional_id, $fecha, $franja_horaria_id);
            $success = 'El servicio se ha añadido con éxito.';
            return Redirect::to('/mostrarHorariosServicios')->with(['success' => $success, 'inicioSemana' => $fechaInicio]);
        }
    }

    public static function getServiciosSemana($array_fechas, $usuario_id = null, $profesional_id = null) {
        $serviciosHorarioOrganizado = [];

        foreach ($array_fechas as $fecha_array) {
            $fecha_formato = Carbon::createFromFormat('d/m/Y', $fecha_array[0])->format('Y-m-d');
            $fecha = $fecha_array[0];
            $fecha_servicio = [
                'fecha' => $fecha,
                'fecha_formato' => $fecha_formato,
                'dia_semana_id' => $fecha_array[1]
            ];

            $serviciosDia = HorarioServicios::getServiciosByDia($fecha_formato, $profesional_id);
                        
            foreach ($serviciosDia as &$servicio) {
                if ($usuario_id) {
                    $reserva_id = ReservaServicio::getReservaServicioId($usuario_id, $servicio->id);
                    $existsReserva = ReservaServicio::existeReservaServicio($servicio->id);
                    $servicio->reserva_id = $reserva_id;
                    $servicio->existsReserva = $existsReserva;
                }

                // Verificar si el servicio ya ha pasado
                $servicio->pasada = ReservasController::isClasePasada($servicio['fecha'], $servicio['franja_horaria_nombre']);
                $serviciosHorarioOrganizado[$fecha_servicio['dia_semana_id']][$servicio->franja_horaria_id][] = $servicio;
            }
        }

        return $serviciosHorarioOrganizado;
    }

    public function eliminarServicioHorarioModal(Request $request) {
        $servicio = HorarioServicios::getServicioById($request->post('id'));
        $inicioSemana = $request->post('fecha');

        return View::make('modals.modalEliminarItemHorario', compact('servicio', 'inicioSemana'));
        die();
    }
    
    public function eliminarServicioHorario(Request $request) {
        $id_servicio = HorarioServicios::eliminarServicio($request->post('servicio_id'));
        $inicioSemana = $request->post('inicioSemana');

        if ($id_servicio) {
            $success = 'La servicio se ha eliminado con éxito';
            return Redirect::to('/mostrarHorariosServicios')->with(['success' => $success, 'inicioSemana' => $inicioSemana]);
        } else {
            $error = 'La servicio no se ha podido eliminar';
            return Redirect::to('/mostrarHorariosServicios')->with(['error' => $error, 'inicioSemana' => $inicioSemana]);
        }
    }
}
