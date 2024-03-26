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
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller; 
use Carbon\Carbon;

use Illuminate\Support\Facades\Log;

class DashboardController extends Controller {
    public function verDashboard() {
        $fechaInicioMesAnterior = Carbon::now()->subMonth()->startOfMonth();
        $fechaFinMesAnterior = Carbon::now()->subMonth()->endOfMonth();
        $fechasMesAnterior = [$fechaInicioMesAnterior, $fechaFinMesAnterior];

        $n_usuarios = Usuario::countUsuariosActivos();
        $n_personal = Personal::countPersonalActivos();
        $n_reservasClasesMes = Reserva::countReservasMes();
        $n_reservasServiciosMes = ReservaServicio::countReservasMes();

        $n_reservasClasesMesAnterior = Reserva::countReservasMes($fechasMesAnterior);
        $n_reservasServiciosMesAnterior = ReservaServicio::countReservasMes($fechasMesAnterior);

        $dif_reservasClases = $this->calcularDiferenciaPorcentaje($n_reservasClasesMes, $n_reservasClasesMesAnterior);
        return view('gymfit/dashboard/dashboard', compact('n_usuarios', 'n_personal', 'n_reservasClasesMes', 'n_reservasServiciosMes', 'n_reservasClasesMesAnterior', 'n_reservasServiciosMesAnterior', 'dif_reservasClases'));
    }

    public function calcularDiferenciaPorcentaje($mes_actual, $mes_anterior) {
        $diferencia = $mes_actual - $mes_anterior;

        if ($mes_anterior != 0) {
            $porcentaje = round(($diferencia / $mes_anterior) * 100);
        } else {
            $porcentaje = 0;
        }

        return $porcentaje;
    }
}
