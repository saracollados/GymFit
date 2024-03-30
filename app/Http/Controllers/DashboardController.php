<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clase;
use App\Models\Usuario;
use App\Models\Sala;
use App\Models\Personal;
use App\Models\Horario;
use App\Models\Reserva;
use App\Models\ReservaServicio;
use App\Models\HorarioClases;
use App\Models\HorarioServicios;
use App\Models\ReservaServicios;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller; 
use App\Http\Controllers\HorariosClasesController; 
use Carbon\Carbon;

use Illuminate\Support\Facades\Log;

class DashboardController extends Controller {
    public function verDashboard() {
        // Fechas mes
        $fechaInicioMesActual = Carbon::now()->startOfMonth();
        $fechaFinMesActual = Carbon::now()->endOfMonth();
        $fechaInicioMesAnterior = Carbon::now()->subMonthsNoOverflow(1)->startOfMonth();
        $fechaFinMesAnterior = Carbon::now()->subMonthsNoOverflow(1)->endOfMonth();
        $fechasMesActual = [$fechaInicioMesActual, $fechaFinMesActual];
        $fechasMesAnterior = [$fechaInicioMesAnterior, $fechaFinMesAnterior];

        $franjasHorarias = Horario::getFranjasHorarias();
        $diasSemana = Horario::getDiasSemana();

        // ---- KPIs ----
        $n_usuarios = Usuario::countUsuariosActivos();
        $n_personal = Personal::countPersonalActivos();
        $n_reservasClasesMes = Reserva::countReservasMes($fechasMesActual);
        $n_reservasServiciosMes = ReservaServicio::countReservasMes($fechasMesActual);

        $n_reservasClasesMesAnterior = Reserva::countReservasMes($fechasMesAnterior);
        $n_reservasServiciosMesAnterior = ReservaServicio::countReservasMes($fechasMesAnterior);
        
        // ---- DETALLES CLASES ----
        $clases = Clase::getAll();
        $monitores = Personal::getPersonalByRole('2');

        $clasesMes = HorariosClasesController::getClasesMes($fechasMesActual);
        $reservasClasesMes = Reserva::getReservasClases(null, null, $fechasMesActual);
        
        $ocupacionTotalClases = $this->getOcupacionTotalClases($clasesMes, $reservasClasesMes);
        $ocupacionClases = $this->getDetallesByClase($clases, $clasesMes, $reservasClasesMes);
        $ocupacionClasesMonitores = $this->getDetallesClasesByMonitor($monitores, $clasesMes, $reservasClasesMes);
        $ocupacionClasesFranjasHorarias = $this->getDetallesClasesByFranjasHorarias($franjasHorarias, $clasesMes, $reservasClasesMes);
        $ocupacionClasesDiasSemana = $this->getDetallesClasesByDiasSemana($diasSemana, $clasesMes, $reservasClasesMes);

        // mes anterior

        $clasesMesAnterior = HorariosClasesController::getClasesMes($fechasMesAnterior);
        $reservasClasesMesAnterior = Reserva::getReservasClases(null, null, $fechasMesAnterior);

        $ocupacionTotalClasesMesAnterior = $this->getOcupacionTotalClases($clasesMesAnterior, $reservasClasesMesAnterior);
        $ocupacionClasesMesAnterior = $this->getDetallesByClase($clases, $clasesMesAnterior, $reservasClasesMesAnterior);
        $ocupacionClasesMonitoresMesAnterior = $this->getDetallesClasesByMonitor($monitores, $clasesMesAnterior, $reservasClasesMesAnterior);
        $ocupacionClasesFranjasHorariasMesAnterior = $this->getDetallesClasesByFranjasHorarias($franjasHorarias, $clasesMesAnterior, $reservasClasesMesAnterior);
        $ocupacionClasesDiasSemanaMesAnterior = $this->getDetallesClasesByDiasSemana($diasSemana, $clasesMesAnterior, $reservasClasesMesAnterior);
        
        // ---- DETALLES SERVICIOS ----
        $servicios = Personal::getRoles('3','4');
        $profesionales = Personal::getPersonalByRole('3', '4');
        
        $serviciosMes = HorarioServicios::getServiciosHorario($fechasMesActual);
        $reservasServiciosMes = ReservaServicio::getReservasServicios(null, null, null, null, $fechasMesActual);
        
        $ocupacionTotalServicios = $this->getOcupacionTotalServicios($serviciosMes, $reservasServiciosMes);
        $ocupacionServicios = $this->getDetallesByServicio($servicios, $serviciosMes, $reservasServiciosMes);
        $ocupacionServiciosProfesionales = $this->getDetallesServiciosByProfesional($profesionales, $serviciosMes, $reservasServiciosMes);
        $ocupacionServiciosDiasSemana = $this->getDetallesServiciosByDiasSemana($diasSemana, $serviciosMes, $reservasServiciosMes);
        $ocupacionServiciosFranjasHorarias = $this->getDetallesServiciosByFranjasHorarias($franjasHorarias, $serviciosMes, $reservasServiciosMes);
        
        // mes anterior
        $serviciosMesAnterior = HorarioServicios::getServiciosHorario($fechasMesAnterior);
        $reservasServiciosMesAnterior = ReservaServicio::getReservasServicios(null, null, null, null, $fechasMesAnterior);

        $ocupacionTotalServiciosMesAnterior = $this->getOcupacionTotalServicios($serviciosMes, $reservasServiciosMesAnterior);

        // ---- DIFERENCIA MES ANTERIOR ----

        $dif_reservasClases = $this->calcularDiferenciaPorcentaje($n_reservasClasesMes, $n_reservasClasesMesAnterior);
        $dif_reservasServicios = $this->calcularDiferenciaPorcentaje($n_reservasServiciosMes, $n_reservasServiciosMesAnterior);



        $datos = [
            'n_usuarios' => $n_usuarios,
            'n_personal' => $n_personal,
            'n_reservasClasesMes' => $n_reservasClasesMes,
            'n_reservasServiciosMes' => $n_reservasServiciosMes,
            'n_reservasClasesMesAnterior' => $n_reservasClasesMesAnterior,
            'n_reservasServiciosMesAnterior' => $n_reservasServiciosMesAnterior,
            'dif_reservasClases' => $dif_reservasClases,
            'dif_reservasServicios' => $dif_reservasServicios,
            'ocupacionTotalClases' => $ocupacionTotalClases,
            'ocupacionTotalServicios' => $ocupacionTotalServicios,
            'ocupacionTotalClasesMesAnterior' => $ocupacionTotalClasesMesAnterior,
            'ocupacionTotalServiciosMesAnterior' => $ocupacionTotalServiciosMesAnterior,
            'ocupacionClases' => $ocupacionClases,
            'ocupacionClasesMonitores' => $ocupacionClasesMonitores,
            'ocupacionClasesDiasSemana' => $ocupacionClasesDiasSemana,
            'ocupacionClasesFranjasHorarias' => $ocupacionClasesFranjasHorarias,
            'ocupacionServicios' => $ocupacionServicios,
            'ocupacionServiciosProfesionales' => $ocupacionServiciosProfesionales,
            'ocupacionServiciosDiasSemana' => $ocupacionServiciosDiasSemana,
            'ocupacionServiciosFranjasHorarias' => $ocupacionServiciosFranjasHorarias,
        ];
        
        return view('gymfit/dashboard/dashboard', compact('datos'));
    }



    public function getOcupacionTotalClases($clasesMes, $reservasMes) {
        $aforo = 0;
        $n_reservas = 0;

        foreach($clasesMes as $claseMes) {
            $aforo += $claseMes['sala_aforo'];
        }

        foreach($reservasMes as $reservaMes) {
            $n_reservas ++;
        }

        if ($aforo != 0) {
            $ocupacionTotalClases = round($n_reservas / $aforo * 100);
        } else {
            $ocupacionTotalClases = 0;
        }

        return $ocupacionTotalClases;
    }
    public function getDetallesByClase($clases, $clasesMes, $reservasMes) {
        $ocupacionClases = [];
        foreach($clases as $clase) {
            $clase_id = $clase->id;

            $aforo = 0;
            $n_reservas = 0;

            foreach($clasesMes as $claseMes) {
                if ($claseMes['clase_id'] == $clase_id) {
                    $aforo += $claseMes['sala_aforo'];
                }
            }

            foreach($reservasMes as $reservaMes) {
                if($reservaMes->clase_id == $clase_id) {
                    $n_reservas ++;
                }
            }

            if ($aforo != 0) {
                $porc_ocupacion = round($n_reservas / $aforo * 100);
            } else {
                $porc_ocupacion = 0;
            }

            $ocupacionClases[] = [$clase->nombre, $porc_ocupacion];
        }

        return $ocupacionClases;
    }

    public function getDetallesClasesByMonitor($monitores, $clasesMes, $reservasMes) {
        $ocupacionMonitores = [];
        foreach($monitores as $monitor) {
            $monitor_id = $monitor->id;

            $aforo = 0;
            $n_reservas = 0;

            foreach($clasesMes as $claseMes) {
                if ($claseMes['monitor_id'] == $monitor_id) {
                    $aforo += $claseMes['sala_aforo'];
                }
            }

            foreach($reservasMes as $reservaMes) {
                if($reservaMes->monitor_id == $monitor_id) {
                    $n_reservas ++;
                }
            }

            if ($aforo != 0) {
                $porc_ocupacion = round($n_reservas / $aforo * 100);
            } else {
                $porc_ocupacion = 0;
            }

            $ocupacionMonitores[] = [$monitor->nombre, $porc_ocupacion];
        }

        return $ocupacionMonitores;
    }

    public function getDetallesClasesByFranjasHorarias($franjasHorarias, $clasesMes, $reservasMes) {
        $ocupacionFranjasHorarias = [];
        foreach($franjasHorarias as $franja) {
            $franja_id = $franja->id;

            $aforo = 0;
            $n_reservas = 0;

            foreach($clasesMes as $claseMes) {
                if ($claseMes['franja_horaria_id'] == $franja_id) {
                    $aforo += $claseMes['sala_aforo'];
                }
            }

            foreach($reservasMes as $reservaMes) {
                if($reservaMes->franja_horaria_id == $franja_id) {
                    $n_reservas ++;
                }
            }

            if ($aforo != 0) {
                $porc_ocupacion = round($n_reservas / $aforo * 100);
            } else {
                $porc_ocupacion = 0;
            }

            $ocupacionFranjasHorarias[] = [$franja->nombre, $porc_ocupacion];
        }

        return $ocupacionFranjasHorarias;
    }

    public function getDetallesClasesByDiasSemana($diasSemana, $clasesMes, $reservasMes) {
        $ocupacionDiasSemana = [];
        foreach($diasSemana as $diaSemana) {
            $diaSemana_id = $diaSemana->id;

            $aforo = 0;
            $n_reservas = 0;

            foreach($clasesMes as $claseMes) {
                if ($claseMes['dia_semana_id'] == $diaSemana_id) {
                    $aforo += $claseMes['sala_aforo'];
                }
            }

            foreach($reservasMes as $reservaMes) {
                if($reservaMes->dia_semana_id == $diaSemana_id) {
                    $n_reservas ++;
                }
            }

            if ($aforo != 0) {
                $porc_ocupacion = round($n_reservas / $aforo * 100);
            } else {
                $porc_ocupacion = 0;
            }

            $ocupacionDiasSemana[] = [$diaSemana->nombre, $porc_ocupacion];
        }

        return $ocupacionDiasSemana;
    }

    public function getOcupacionTotalServicios($serviciosMes, $reservasMes) {
        $aforo = 0;
        $n_reservas = 0;

        foreach($serviciosMes as $servicioMes) {
            $aforo ++;
        }

        foreach($reservasMes as $reservaMes) {
            $n_reservas ++;
        }

        if ($aforo != 0) {
            $ocupacionServicios = round($n_reservas / $aforo * 100);
        } else {
            $ocupacionServicios = 0;
        }


        return $ocupacionServicios;
    }

    public function getDetallesByServicio($servicios, $serviciosMes, $reservasMes) {
        $ocupacionServicios = [];
        foreach($servicios as $servicio) {
            $servicio_id = $servicio->id;

            $aforo = 0;
            $n_reservas = 0;

            foreach($serviciosMes as $servicioMes) {
                if ($servicioMes['role_id'] == $servicio_id) {
                    $aforo ++;
                }
            }

            foreach($reservasMes as $reservaMes) {
                if($reservaMes->role_id == $servicio_id) {
                    $n_reservas ++;
                }
            }

            if ($aforo != 0) {
                $porc_ocupacion = round($n_reservas / $aforo * 100);
            } else {
                $porc_ocupacion = 0;
            }

            $ocupacionServicios[] = [$servicio->nombre, $porc_ocupacion, $n_reservas, $aforo];
        }

        return $ocupacionServicios;
    }

    public function getDetallesServiciosByProfesional($profesionales, $serviciosMes, $reservasMes) {
        $ocupacionProfesionales = [];
        foreach($profesionales as $profesional) {
            $profesional_id = $profesional->id;

            $aforo = 0;
            $n_reservas = 0;

            foreach($serviciosMes as $servicioMes) {
                if ($servicioMes['profesional_id'] == $profesional_id) {
                    $aforo ++;
                }
            }

            foreach($reservasMes as $reservaMes) {
                if($reservaMes->profesional_id == $profesional_id) {
                    $n_reservas ++;
                }
            }

            if ($aforo != 0) {
                $porc_ocupacion = round($n_reservas / $aforo * 100);
            } else {
                $porc_ocupacion = 0;
            }

            $ocupacionProfesionales[] = [$profesional->nombre, $porc_ocupacion];
        }

        return $ocupacionProfesionales;
    }

    public function getDetallesServiciosByFranjasHorarias($franjasHorarias, $clasesMes, $reservasMes) {
        $ocupacionFranjasHorarias = [];
        foreach($franjasHorarias as $franja) {
            $franja_id = $franja->id;

            $aforo = 0;
            $n_reservas = 0;

            foreach($clasesMes as $claseMes) {
                if ($claseMes['franja_horaria_id'] == $franja_id) {
                    $aforo ++;
                }
            }

            foreach($reservasMes as $reservaMes) {
                if($reservaMes->franja_horaria_id == $franja_id) {
                    $n_reservas ++;
                }
            }

            if ($aforo != 0) {
                $porc_ocupacion = round($n_reservas / $aforo * 100);
            } else {
                $porc_ocupacion = 0;
            }

            $ocupacionFranjasHorarias[] = [$franja->nombre, $porc_ocupacion];
        }

        return $ocupacionFranjasHorarias;
    }

    public function getDetallesServiciosByDiasSemana($diasSemana, $serviciosMes, $reservasMes) {
        $ocupacionDiasSemana = [];
        foreach($diasSemana as $diaSemana) {
            $diaSemana_id = $diaSemana->id;

            $aforo = 0;
            $n_reservas = 0;

            foreach($serviciosMes as $servicioMes) {
                $fecha = $servicioMes->fecha;
                $fechaCarbon = Carbon::createFromFormat('Y-m-d', $fecha);
                $numeroDiaSemana = $fechaCarbon->dayOfWeek;
                if ($numeroDiaSemana == 0) {
                    $numeroDiaSemana = 7;
                }

                if ($numeroDiaSemana == $diaSemana_id) {
                    $aforo ++;
                }
            }

            foreach($reservasMes as $reservaMes) {
                $fecha = $reservaMes->fecha;
                $fechaCarbon = Carbon::createFromFormat('Y-m-d', $fecha);
                $numeroDiaSemana = $fechaCarbon->dayOfWeek;
                if ($numeroDiaSemana == 0) {
                    $numeroDiaSemana = 7;
                }

                if($numeroDiaSemana == $diaSemana_id) {
                    $n_reservas ++;
                }
            }

            if ($aforo != 0) {
                $porc_ocupacion = round($n_reservas / $aforo * 100);
            } else {
                $porc_ocupacion = 0;
            }

            $ocupacionDiasSemana[] = [$diaSemana->nombre, $porc_ocupacion];
        }

        return $ocupacionDiasSemana;
    }

    public function calcularDiferenciaPorcentaje($mes_actual, $mes_anterior) {
        $diferencia = $mes_actual - $mes_anterior;

        if ($mes_anterior != 0) {
            $porcentaje = round(($diferencia / $mes_anterior * 100));
        } else {
            $porcentaje = 100;
        }

        $porcentajeConSigno = $porcentaje >= 0 ? '+' . $porcentaje : $porcentaje;

        return $porcentajeConSigno;
    }
}
