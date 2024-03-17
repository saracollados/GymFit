<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Reserva extends Model {
    use HasFactory;

    public function clase() {
        return $this->belongsTo(Clase::class);
    }

    public function usuario() {
        return $this->belongsTo(Usuario::class);
    }

    public static function getReservasClases($id = null) {
        $reservas = Reserva::join('usuarios', 'reservas.usuario_id', '=', 'usuarios.id')
            ->join('horarios_clases', 'reservas.clase_id', '=', 'horarios_clases.id')
            ->join('clases_historico', 'reservas.fecha_id', '=', 'clases_historico.id')
            ->join('clases', 'horarios_clases.clase_id', '=', 'clases.id')
            ->join('dias_semana_tabla_maestra', 'horarios_clases.dia_semana_id', '=', 'dias_semana_tabla_maestra.id')
            ->join('franjas_horarias_tabla_maestra', 'horarios_clases.franja_horaria_id', '=', 'franjas_horarias_tabla_maestra.id')
            ->join('personal', 'horarios_clases.monitor_id', '=', 'personal.id')
            ->join('salas', 'horarios_clases.sala_id', '=', 'salas.id')
            ->select('reservas.id',
            'usuarios.id as usuario_id',
            'usuarios.dni as usuario_dni',
            'usuarios.nombre as usuario_nombre',
            'clases_historico.id as fecha_id',
            'clases_historico.fecha as fecha',
            'clases.id as clase_id',
            'clases.nombre as clase_nombre',
            'dias_semana_tabla_maestra.id as dia_semana_id',
            'dias_semana_tabla_maestra.nombre as dia_semana_nombre',
            'franjas_horarias_tabla_maestra.id as franja_horaria_id',
            'franjas_horarias_tabla_maestra.nombre as franja_horaria_nombre',
            'personal.id as monitor_id',
            'personal.nombre as monitor_nombre',
            'salas.id as sala_id',
            'salas.nombre as sala_nombre')
            ->when($id, function ($query, $id) {
                return $query->where('reservas.usuario_id', $id);
            })
            ->get();

        return $reservas;
    }

    public static function getReservasServicios() {
        $reservas = new \Illuminate\Database\Eloquent\Collection;
        return $reservas;
    }

    public static function getPlazasOcupadas($clase_id, $fecha_id) {
        $plazasOcupadas = Reserva::where('clase_id', $clase_id)
            ->where('fecha_id', $fecha_id)
            ->count();

        return $plazasOcupadas;
    }

    public static function getReservaId($usuario_id, $clase_id, $fecha_id) {
        $reserva_id = Reserva::where('usuario_id', '=', $usuario_id)
            ->where('clase_id', '=', $clase_id)
            ->where('fecha_id', '=', $fecha_id)
            ->select('id')
            ->first();

        return $reserva_id;
    }

    public static function existeReservaHora ($usuario_id, $fecha_id, $franja_horaria_id) {
        $existeReservaHora = Reserva::join('usuarios', 'reservas.usuario_id', '=', 'usuarios.id')
            ->join('horarios_clases', 'reservas.clase_id', '=', 'horarios_clases.id')
            ->join('clases_historico', 'reservas.fecha_id', '=', 'clases_historico.id')
            ->join('clases', 'horarios_clases.clase_id', '=', 'clases.id')
            ->select('reservas.id',
                'usuarios.id as usuario_id',
                'clases_historico.id as fecha_id',
                'horarios_clases.franja_horaria_id as franja_horaria_id')
            ->where('usuario_id', '=', $usuario_id)
            ->where('fecha_id', '=', $fecha_id)
            ->where('franja_horaria_id', '=', $franja_horaria_id)
            ->exists();

        return $existeReservaHora;
    }

    public static function create (Request $request) {
        $reserva = new Reserva();
        $reserva->usuario_id = $request->input('usuario_id');
        $reserva->clase_id = $request->input('clase_id'); 
        $reserva->fecha_id = $request->input('fecha_id');
        $reserva->save(); 

        return $reserva->id;
    }

    public static function deleteReserva ($reserva_id) {
        $reserva = Reserva::find($reserva_id);
        $reserva->delete();
    }

}
