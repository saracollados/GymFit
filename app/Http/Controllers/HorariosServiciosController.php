<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personal;
use App\Models\Horario;
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
        $fechasSemanaActual = [];
        for ($i = 0; $i < 7; $i++) {
            $fecha = $inicioSemanaActual->copy()->addDays($i);
            $fechasSemanaActual[] = [$fecha->format('d/m/Y'), ($fecha->dayOfWeek == 0) ? 7 : $fecha->dayOfWeek];
        }

        // Calcula las fechas de la semana siguiente
        $inicioSemanaSiguiente = $inicioSemanaActual->copy()->addWeek()->startOfWeek();
        $fechasSemanaSiguiente = [];
        for ($i = 0; $i < 7; $i++) {
            $fecha = $inicioSemanaSiguiente->copy()->addDays($i);
            $fechasSemanaSiguiente[] = [$fecha->format('d/m/Y'), ($fecha->dayOfWeek == 0) ? 7 : $fecha->dayOfWeek];
        }

        // Calcula las fechas de la semana anterior
        $inicioSemanaAnterior = $inicioSemanaActual->copy()->subWeek()->startOfWeek();
        $fechasSemanaAnterior = [];
        for ($i = 0; $i < 7; $i++) {
            $fecha = $inicioSemanaAnterior->copy()->addDays($i);
            $fechasSemanaAnterior[] = [$fecha->format('d/m/Y'), ($fecha->dayOfWeek == 0) ? 7 : $fecha->dayOfWeek];
        }

        $serviciosSemanaActual = HorariosServiciosController::getServiciosSemana($fechasSemanaActual);
        $serviciosSemanaSiguiente = HorariosServiciosController::getServiciosSemana($fechasSemanaSiguiente);
        $serviciosSemanaAnterior = HorariosServiciosController::getServiciosSemana($fechasSemanaAnterior);

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
        $diasSemana = Horario::getDiasSemana();
        $franjasHorarias = Horario::getFranjasHorarias();
        $profesionales = Personal::getPersonalByRole('3', '4');
        $success = '';
        $error = '';

        if ($existeServicio) {
            $error = 'Ese profesional ya tiene un servicio a esa hora.';
            return Redirect::to('/mostrarHorariosServicios')->with(['error' => $error, 'inicioSemana' => $fechaInicio]);
        } else {
            $id_servicio = HorarioServicios::create($profesional_id, $fecha, $franja_horaria_id);
            $success = 'El servicio se ha añadido con éxito.';
            return Redirect::to('/mostrarHorariosServicios')->with(['success' => $success, 'inicioSemana' => $fechaInicio]);
        }
    }

    public function getServiciosSemana($array_fechas) {
        $serviciosHorarioOrganizado = [];

        foreach ($array_fechas as $fecha_array) {
            $fecha_formato = Carbon::createFromFormat('d/m/Y', $fecha_array[0])->format('Y-m-d');
            $fecha = $fecha_array[0];
            $fecha_servicio = [
                'fecha' => $fecha,
                'fecha_formato' => $fecha_formato,
                'dia_semana_id' => $fecha_array[1]
            ];
            
            $serviciosDia = HorarioServicios::getServiciosByDia($fecha_formato);
            
            
            foreach ($serviciosDia as &$servicio) {
                $serviciosHorarioOrganizado[$fecha_servicio['dia_semana_id']][$servicio->franja_horaria_id][] = $servicio;
            }
        }
        
        return $serviciosHorarioOrganizado;
    }
}
