<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReservaServicio extends Model {
    use HasFactory;

    public function usuario() {
        return $this->belongsTo(Usuario::class);
    }

    protected $table = 'reservas_servicios';

    public static function getReservasServicios($usuario_id = null, $profesional_id = null, $fecha = null, $franja_horaria_id = null) {
        $reservasServicios = ReservaServicio::join('usuarios', 'usuarios.id', '=', 'reservas_servicios.usuario_id')
            ->join ('horarios_servicios', 'horarios_servicios.id', '=', 'reservas_servicios.servicio_id')
            ->join ('personal', 'personal.id', '=', 'horarios_servicios.personal_id')
            ->join ('roles_personal_tabla_maestra', 'personal.role_id', '=', 'roles_personal_tabla_maestra.id')
            ->join ('franjas_horarias_tabla_maestra', 'franjas_horarias_tabla_maestra.id', '=', 'horarios_servicios.franja_horaria_id')
            ->select('reservas_servicios.id as id',
            'reservas_servicios.usuario_id as usuario_id',
            'usuarios.nombre as usuario_nombre',
            'usuarios.dni as usuario_dni',
            'reservas_servicios.servicio_id as servicio_id',
            'horarios_servicios.personal_id as profesional_id', 
            'personal.nombre as profesional_nombre',
            'roles_personal_tabla_maestra.id as role_id',
            'roles_personal_tabla_maestra.nombre as role_nombre',
            'horarios_servicios.fecha as fecha',
            'horarios_servicios.franja_horaria_id as franja_horaria_id',
            'franjas_horarias_tabla_maestra.nombre as franja_horaria_nombre')
            ->when($usuario_id, function ($query, $usuario_id) {
                return $query->where('reservas_servicios.usuario_id', $usuario_id);
            })
            ->when($profesional_id, function ($query, $profesional_id) {
                return $query->where('horarios_servicios.personal_id', $profesional_id);
            })
            ->when($fecha, function ($query, $fecha) {
                return $query->where('horarios_servicios.fecha', $fecha);
            })
            ->when($franja_horaria_id, function ($query, $franja_horaria_id) {
                return $query->where('horarios_servicios.franja_horaria_id', $franja_horaria_id);
            })
            ->orderByDesc('horarios_servicios.fecha')
            ->orderByDesc('horarios_servicios.franja_horaria_id')
            ->get();

        return $reservasServicios;
    }

    public static function countReservasMes($fechasMes = null) {
        $query = ReservaServicio::join('horarios_servicios', 'reservas_servicios.servicio_id', '=', 'horarios_servicios.id')
            ->select('reservas_servicios.id', 'horarios_servicios.fecha');

        $query->when(!$fechasMes, function ($query) {
            $query->whereYear('horarios_servicios.fecha', now()->year)
                  ->whereMonth('horarios_servicios.fecha', now()->month);
        });
        $query->when($fechasMes, function ($query) use ($fechasMes) {
            $query->whereBetween('horarios_servicios.fecha', [$fechasMes[0], $fechasMes[1]]);
        });

        $count = $query->count();
        
        return $count;
    }

    public static function getReservaById($reserva_id) {
        $reserva = ReservaServicio::join('usuarios', 'usuarios.id', '=', 'reservas_servicios.usuario_id')
            ->join ('horarios_servicios', 'horarios_servicios.id', '=', 'reservas_servicios.servicio_id')
            ->join ('personal', 'personal.id', '=', 'horarios_servicios.personal_id')
            ->join ('roles_personal_tabla_maestra', 'personal.role_id', '=', 'roles_personal_tabla_maestra.id')
            ->join ('franjas_horarias_tabla_maestra', 'franjas_horarias_tabla_maestra.id', '=', 'horarios_servicios.franja_horaria_id')
            ->select('reservas_servicios.id as id',
            'reservas_servicios.usuario_id as usuario_id',
            'usuarios.nombre as usuario_nombre',
            'usuarios.dni as usuario_dni',
            'reservas_servicios.servicio_id as servicio_id',
            'horarios_servicios.personal_id as profesional_id', 
            'personal.nombre as profesional_nombre',
            'roles_personal_tabla_maestra.id as role_id',
            'roles_personal_tabla_maestra.nombre as role_nombre',
            'horarios_servicios.fecha as fecha',
            'horarios_servicios.franja_horaria_id as franja_horaria_id',
            'franjas_horarias_tabla_maestra.nombre as franja_horaria_nombre')
            ->where('reservas_servicios.id', $reserva_id)
            ->first();

        return $reserva;
    }
    
    public static function getReservasByUsuarioId($usuario_id) {
        $reservasUsuario = ReservaServicio::where('usuario_id', $usuario_id)
            ->get();

        return $reservasUsuario;
    }

    public static function getReservaServicioId($usuario_id, $servicio_id) {
        $reserva_id =  ReservaServicio::where('usuario_id', '=', $usuario_id)
            ->where('servicio_id', '=', $servicio_id)
            ->select('id')
            ->first();

        return $reserva_id;
    }

    public static function existeReservaServicio ($servicio_id) {
        $existeReservaServicio = ReservaServicio::where('servicio_id', '=', $servicio_id)
            ->exists();

        return $existeReservaServicio;
    }

    public static function createServicio (Request $request) {
        
        $reserva = new ReservaServicio();
        $reserva->usuario_id = $request->input('usuario_id');
        $reserva->servicio_id = $request->input('servicio_id'); 
        $reserva->save(); 

        return $reserva->id;
    }

    public static function deleteReserva ($reserva_id) {
        $reserva = ReservaServicio::find($reserva_id);
        $reserva->delete();

        return true;
    }

    public static function deleteReservaByServicioId ($servicio_id) {
        $reserva = ReservaServicio::where('servicio_id', '=', $servicio_id);
        $reserva->delete();

        return true;
    }

}
