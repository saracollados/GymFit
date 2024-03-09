<?php

namespace App\Models;

use DateTime;
use DatePeriod;
use DateInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Horario extends Model {
    use HasFactory;

    public function clase() {
        return $this->hasMany(Clase::class);
    }

    public static function getHorarios() {
        $horarios = DB::table('horarios')
            ->select('*')
            ->where('activo', '=', true)
            ->get();

        return $horarios;
    }

    public static function getHorarioById($id) {
        $horario = DB::table('horarios')
            ->select('*')
            ->where('id', '=', $id)
            ->first();

        return $horario;
    }
    
    public static function getDiasSemana() {
        $diasSemana = DB::table('dias_semana_tabla_maestra')
            ->select('*')
            ->get();
        return $diasSemana;
    }

    public static function getDiaSemanaById($id) {
        $diaSemana = DB::table('dias_semana_tabla_maestra')->where('id', $id)
            ->select('nombre')
            ->first();
        return $diaSemana->nombre;
    }

    public static function getFranjasHorarias() {
        $diasSemana = DB::table('franjas_horarias_tabla_maestra')
            ->select('*')
            ->get();
        return $diasSemana;
    }

    public static function create(Request $request) {
        $horario = new Horario();
        $horario->nombre = $request->input('nombre');
        $horario->save(); 
    
        return $horario->id;
    }

    public static function eliminar($id) {
        $horario = Horario::where('id', $id)
            ->update(['activo' => 0]);
            
        return $horario;
    }

    public static function createHistoricoClases(Request $request, $id_horario) {
        $fecha_desde = new DateTime($request->input('fecha_desde'));
        $fecha_hasta = new DateTime($request->input('fecha_hasta'));

        
        $intervalo = new DateInterval('P1D');
        $fecha_hasta->add(new DateInterval('P1D'));
        $periodo = new DatePeriod($fecha_desde, $intervalo, $fecha_hasta);
        
        $fechas_entre = [];
        foreach($periodo as $fecha) {
            $fechas_entre[] = $fecha->format('Y-m-d');
        }

        foreach ($fechas_entre as $fecha) {
            $existe_fecha = DB::table('clases_historico')->where('fecha', $fecha)->exists();

            if ($existe_fecha) {
                DB::table('clases_historico')
                    ->where('fecha', $fecha)
                    ->update(['horario_id' => $id_horario]);
            } else {
                DB::table('clases_historico')
                    ->insert([
                        'fecha' => $fecha,
                        'horario_id' => $id_horario
                ]);
            }
        }
    }
}
