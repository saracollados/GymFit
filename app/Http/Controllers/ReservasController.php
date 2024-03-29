<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\ReservaServicio;
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
    public function mostrarReservasClases() {
        $usuarioInfo = session('userInfo');
        $usuarioTipo = session('userType');
        $isUsuarioAdmin = session('isAdmin');
        $isUsuarioClases = session('isClases');
        $isUsuarioServicios = session('isServicios');
        
        if ($usuarioTipo == 'usuario') {
            $reservasClases = Reserva::getReservasClases($usuarioInfo['id'], null);
        } elseif ($usuarioTipo == 'personal' && $isUsuarioClases) {
            $reservasClases = Reserva::getReservasClases(null, $usuarioInfo['id']);
        } elseif ($usuarioTipo == 'personal' && $isUsuarioAdmin) {
            $reservasClases = Reserva::getReservasClases();
        }

        $success = session('success');
        $error = session('error');

        foreach ($reservasClases as &$reserva) {
            $reserva->pasada = ReservasController::isClasePasada($reserva->fecha, $reserva->franja_horaria_nombre);
        }
        
        return view('gymfit/reservas/mostrarReservasClases', compact('reservasClases', 'usuarioInfo', 'success', 'error'));
    }

    public function mostrarReservasServicios() {
        $usuarioInfo = session('userInfo');
        $usuarioTipo = session('userType');
        
        if ($usuarioTipo == 'usuario') {
            $usuario_id = $usuarioInfo['id'];
            $reservasServicios = ReservaServicio::getReservasServicios($usuarioInfo['id']);
            
        } elseif(session('isServicios')) { 
            $profesional_id = $usuarioInfo['id'];
            $reservasServicios = ReservaServicio::getReservasServicios(null, $profesional_id);
        } else {
            $reservasServicios = ReservaServicio::getReservasServicios();
        }

        foreach ($reservasServicios as &$reserva) {
            $reserva->pasada = ReservasController::isClasePasada($reserva->fecha, $reserva->franja_horaria_nombre);
        }

        $success = session('success');
        $error = session('error');

        return view('gymfit/reservas/mostrarReservasServicios', compact('reservasServicios', 'success', 'error'));
    }

    public function usuarioReservaModal(Request $request){
        $tipo = $request->post('tipo');
        return View::make('modals.modalUsuarioReserva', compact('tipo'));
        die();
    }

    public function reservaClaseForm(Request $request){
        $usuario_id = $request->post('usuario_id');
        $usuario = Usuario::getUsuarioById($usuario_id);
        $item = $request->post('item');
        $reserva = $request->post('reserva');
        $fecha = $request->post('fecha');
        $tipo = $request->post('type');

        $item['existsReserva'] = (isset($item['existsReserva']) && $item['existsReserva'] === "true") ? true : false;
        $item['pasada'] = (isset($item['pasada']) && $item['pasada'] === "true") ? true : false;

        return View::make('modals.modalCrearReserva', compact('usuario_id', 'item', 'usuario', 'reserva', 'fecha', 'tipo'));
        die();
    }

    public function crearReservaClaseForm(Request $request, $success=null, $error=null) {
        $usuario_dni = $request->post('dni');

        $usuario = Usuario::existsUsuarioDni($usuario_dni);

        if(!$usuario) {
            $reservasClases = Reserva::getReservasClases();
            $error = 'El usuario indicado no existe.';

            return redirect('/mostrarReservasClases')->with(compact('error'));
        } else {

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
            

            Carbon::setWeekStartsAt(Carbon::MONDAY);
    
            $diasSemana = Horario::getDiasSemana();
            $franjasHorarias = Horario::getFranjasHorarias();
    
            // Calcula las fechas de la semana actual
            $fechasSemanaActual = HorariosController::getFechasSemana($inicioSemanaActual);

            // Calcula las fechas de la semana siguiente
            $inicioSemanaActual = Carbon::parse($inicioSemanaActual)->startOfWeek();
            $inicioSemanaSiguiente = $inicioSemanaActual->copy()->addWeek()->startOfWeek();
            $fechasSemanaSiguiente = HorariosController::getFechasSemana($inicioSemanaSiguiente);
            
            // Calcula las fechas de la semana anterior
            $inicioSemanaAnterior = $inicioSemanaActual->copy()->subWeek()->startOfWeek();
            $fechasSemanaAnterior = HorariosController::getFechasSemana($inicioSemanaAnterior);
            
    
            $clasesSemanaActual = ReservasController::getClasesSemanaUsuario($fechasSemanaActual, $usuario->id);

            foreach ($fechasSemanaActual as &$fecha) {
                $diaSemana = Horario::getDiaSemanaById($fecha[1]);
                $diaSemana = $diaSemana;
                $fecha[] = $diaSemana;
            }

            if (isset($error)) {
                return view('gymfit/reservas/crearReservaClaseForm', compact('clasesSemanaActual', 'fechasSemanaActual', 'fechasSemanaSiguiente', 'fechasSemanaAnterior', 'franjasHorarias', 'usuario', 'error'));
            } elseif (isset($success)) {
                return view('gymfit/reservas/crearReservaClaseForm', compact('clasesSemanaActual', 'fechasSemanaActual', 'fechasSemanaSiguiente', 'fechasSemanaAnterior', 'franjasHorarias', 'usuario', 'success'));
            } else {
                return view('gymfit/reservas/crearReservaClaseForm', compact('clasesSemanaActual', 'fechasSemanaActual', 'fechasSemanaSiguiente', 'fechasSemanaAnterior', 'franjasHorarias', 'usuario'));
            }
        }
    }

    public function crearReservaServicioForm(Request $request, $success = null, $error = null) {
        $usuario_dni = $request->post('dni');

        $usuario = Usuario::existsUsuarioDni($usuario_dni);

        if(!$usuario) {
            $reservasServicios = ReservaServicio::getReservasServicios();
            $error = 'El usuario indicado no existe.';

            return redirect('/mostrarReservasServicios')->with(compact('error'));
        } else {    
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

            Carbon::setWeekStartsAt(Carbon::MONDAY);

            $diasSemana = Horario::getDiasSemana();
            $franjasHorarias = Horario::getFranjasHorarias();
    
            // Calcula las fechas de la semana actual
            $fechasSemanaActual = HorariosController::getFechasSemana($inicioSemanaActual);

            // Calcula las fechas de la semana siguiente
            $inicioSemanaActual = Carbon::parse($inicioSemanaActual)->startOfWeek();
            $inicioSemanaSiguiente = $inicioSemanaActual->copy()->addWeek()->startOfWeek();
            $fechasSemanaSiguiente = HorariosController::getFechasSemana($inicioSemanaSiguiente);
            
            // Calcula las fechas de la semana anterior
            $inicioSemanaAnterior = $inicioSemanaActual->copy()->subWeek()->startOfWeek();
            $fechasSemanaAnterior = HorariosController::getFechasSemana($inicioSemanaAnterior);

            if(session('isServicios')) {
                $profesional_id = session('userInfo')['id'];
                $serviciosSemanaActual = HorariosServiciosController::getServiciosSemana($fechasSemanaActual, $usuario->id, $profesional_id);
            } else {
                $serviciosSemanaActual = HorariosServiciosController::getServiciosSemana($fechasSemanaActual, $usuario->id);
            }
    

            foreach ($fechasSemanaActual as &$fecha) {
                $diaSemana = Horario::getDiaSemanaById($fecha[1]);
                $diaSemana = $diaSemana;
                $fecha[] = $diaSemana;
            }

            $error = 'No se ha podido eliminar la reserva.';

            if (isset($error)) {
                return view('gymfit/reservas/crearReservaServicioForm', compact('serviciosSemanaActual', 'fechasSemanaActual', 'fechasSemanaSiguiente', 'fechasSemanaAnterior', 'franjasHorarias', 'usuario', 'error'));
            } elseif (isset($success)) {
                return view('gymfit/reservas/crearReservaServicioForm', compact('serviciosSemanaActual', 'fechasSemanaActual', 'fechasSemanaSiguiente', 'fechasSemanaAnterior', 'franjasHorarias', 'usuario', 'success'));
            } else {
                return view('gymfit/reservas/crearReservaServicioForm', compact('serviciosSemanaActual', 'fechasSemanaActual', 'fechasSemanaSiguiente', 'fechasSemanaAnterior', 'franjasHorarias', 'usuario'));
            }
        }
    }

    public static function getClasesSemanaUsuario($array_fechas, $usuario_id, $profesional_id = null) {
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
                $horario_id = null;
            }


            if($profesional_id) {
                $clasesDia = HorarioClases::getClasesByHorarioDia($horario_id, $dia_semana_id, $profesional_id);
            } else {
                $clasesDia = HorarioClases::getClasesByHorarioDia($horario_id, $dia_semana_id);
            }


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
    
                    if ($usuario_id) {
                        $reserva_id = Reserva::getReservaId($usuario_id, $clase->id, $clase->fecha['fecha_id']);
                        $clase->reserva_id = $reserva_id;
                    } 
    
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

    public static function isClasePasada($fecha_clase, $franja_horaria_clase) {
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
        $inicioSemana = $request->input('inicioSemana');

        $reserva_usuario = Reserva::getReservaId($usuario_id, $clase_id, $fecha_id);
        $reserva_clase = Reserva::existeReservaHora($usuario_id, $fecha_id, $franja_horaria_id);

        $nuevoRequest = ['inicioSemana', $inicioSemana];
        $request->merge($nuevoRequest);

        if($reserva_usuario) {
            $error = 'El usuario ya tiene reservada esta clase.';
            return $this->crearReservaClaseForm($request, null, $error);
        }

        if($reserva_clase) {
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

    public function eliminarReservaClaseForm(Request $request) {
        $reserva_id = $request->input('reserva_id');
        $type = $request->input('type');

        if($type == 'clases') {
            $reserva = Reserva::getReservaById($reserva_id);
        }
        if($type == 'servicios') {
            $reserva = ReservaServicio::getReservaById($reserva_id);
        }

        return View::make('modals.modalEliminarReservaList', compact('reserva', 'type'));
        die();
    }

    public function eliminarReservaClaseList(Request $request) {
        $reserva_id = $request->input('reserva_id');
        $type = $request->input('type');

        if ($reserva_id) {
            if ($type == 'clase') {
                $reserva = Reserva::deleteReserva($reserva_id);
            } elseif ($type == 'servicio') {
                $reserva = ReservaServicio::deleteReserva($reserva_id);
            }

            if ($reserva) {
                if ($type == 'clase') {
                    $success = 'La reserva se ha eliminado con éxito.';
                    return redirect('/mostrarReservasClases')->with(compact('success'));
                } elseif ($type == 'servicio') {
                    $success = 'La reserva se ha eliminado con éxito.';
                    return redirect('/mostrarReservasServicios')->with(compact('success'));
                }
            } else {
                if ($type == 'clase') {
                    $error = 'No se ha podido eliminar la reserva.';
                    return redirect('/mostrarReservasClases')->with(compact('error'));
                } elseif ($type == 'servicio') {
                    $error = 'No se ha podido eliminar la reserva.';
                    return redirect('/mostrarReservasServicios')->with(compact('error'));
                }
            }

        
        } else {
            $error = 'No se ha podido eliminar la reserva.';
            return redirect('/mostrarReservasClases')->with(compact('error'));
        }
    }

    public function eliminarReservaClase(Request $request) {
        $usuario_id = $request->input('usuario_id');
        $clase_id = $request->input('clase_id'); 
        $fecha_id = $request->input('fecha_id');
        $inicioSemana = $request->input('inicioSemana');

        $usuario = Usuario::getUsuarioById($usuario_id);
        $nuevoRequest = ['dni' => $usuario->dni, 'inicioSemana', $inicioSemana];
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

    public function crearReservaServicio (Request $request) {
        $usuario_id = $request->input('usuario_id');
        $servicio = json_decode($_POST['servicio'], true); 
        $servicio_id = $request->input('servicio_id');
        $fecha = $request->input('fecha');
        $franja_horaria_id = $request->input('franja_horaria_id');
        $inicioSemana = $request->input('inicioSemana');

        $nuevoRequest = ['inicioSemana', $inicioSemana];
        $request->merge($nuevoRequest);
        $reservaHoraUsuario = ReservaServicio::getReservasServicios($usuario_id, null, $fecha, $franja_horaria_id);

        if ($servicio['pasada']) {
            $error = 'No se puesen reservar servicios pasados.';
            return $this->crearReservaServicioForm($request, null, $error);
        }
        if($servicio['reserva_id']) {
            $error = 'El usuario ya tiene reservado ese servicio.';
            return $this->crearReservaServicioForm($request, null, $error);
        }
        if($servicio['existsReserva']) {
            $error = 'Ese servicio ya esta reservado.';
            return $this->crearReservaServicioForm($request, null, $error);
        }
        if(count($reservaHoraUsuario) != 0) {
            $error = 'El usuario ya tiene reservado un servicio a esa hora.';
            return $this->crearReservaServicioForm($request, null, $error);
        }

        $id_reserva = ReservaServicio::createServicio($request);

        if ($id_reserva) {
            $success = 'La reserva se ha realizado con éxito.';
            return $this->crearReservaServicioForm($request, $success, null);
        } else {
            $error = 'No se ha podido realizar la reserva.';
            return $this->crearReservaServicioForm($request, null, $error);
        }

    }
    public function eliminarReservaServicio(Request $request) {
        $reserva_id = $request->input('reserva_id');

        if ($reserva_id) {
            ReservaServicio::deleteReserva($reserva_id);
            $success = 'La reserva se ha eliminado con éxito.';
            return $this->crearReservaServicioForm($request, $success, null);
        } else {
            $error = 'No se ha podido eliminar la reserva.';
            return $this->crearReservaServicioForm($request, null, $error);
        }
    }
}
