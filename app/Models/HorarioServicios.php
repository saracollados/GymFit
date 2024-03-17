<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

class HorarioServicios extends Model {
    use HasFactory;

    // Añadir relaciones con otros modelos!!
    protected $fillable = ['id'];

    protected $table = 'horarios_servicios';

    public static function getServiciosHorario() {
        $serviciosHorario = HorarioServicios::join ('personal', 'personal.id', '=', 'horarios_servicios.personal_id')
            ->join('roles_personal_tabla_maestra', 'personal.role_id', '=', 'roles_personal_tabla_maestra.id')
            ->join ('franjas_horarias_tabla_maestra', 'franjas_horarias_tabla_maestra.id', '=', 'horarios_servicios.franja_horaria_id')
            ->select(
                'horarios_servicios.id',
                'horarios_servicios.personal_id as profesional_id', 
                'personal.nombre as profesional_nombre',
                'roles_personal_tabla_maestra.id as role_id',
                'roles_personal_tabla_maestra.nombre as role_nombre',
                'horarios_servicios.fecha as fecha',
                'horarios_servicios.franja_horaria_id as franja_horaria_id',
                'franjas_horarias_tabla_maestra.nombre as franja_horaria_nombre')
            ->get();

        return $serviciosHorario;
    }

    public static function existeServicio($profesional_id, $fecha, $franja_horaria_id) {
        $existeRegistro = HorarioServicios::where('personal_id', $profesional_id)
            ->where('fecha', $fecha)
            ->where('franja_horaria_id', $franja_horaria_id)
            ->exists();
        
        return $existeRegistro;
    }

    public static function create($profesional_id, $fecha, $franja_horaria_id) {
        $servicio = new HorarioServicios();
        $servicio->fecha = $fecha;
        $servicio->franja_horaria_id = $franja_horaria_id;
        $servicio->personal_id = $profesional_id;
        $servicio->save(); 

        return $servicio->id;
    }

    public static function getServiciosByDia($fecha) {
        $serviciosDia = HorarioServicios::join ('personal', 'personal.id', '=', 'horarios_servicios.personal_id')
            ->join('roles_personal_tabla_maestra', 'personal.role_id', '=', 'roles_personal_tabla_maestra.id')
            ->join ('franjas_horarias_tabla_maestra', 'franjas_horarias_tabla_maestra.id', '=', 'horarios_servicios.franja_horaria_id')
            ->select(
                'horarios_servicios.id',
                'horarios_servicios.personal_id as profesional_id', 
                'personal.nombre as profesional_nombre',
                'roles_personal_tabla_maestra.id as role_id',
                'roles_personal_tabla_maestra.nombre as role_nombre',
                'horarios_servicios.fecha as fecha',
                'horarios_servicios.franja_horaria_id as franja_horaria_id',
                'franjas_horarias_tabla_maestra.nombre as franja_horaria_nombre')
            ->where('fecha', '=', $fecha)
            ->get();

        return $serviciosDia;
    }

    public static function eliminarClase($id) {
        $clase = HorarioClases::find($id);
        $clase->delete();
        return $clase;
    }
}
