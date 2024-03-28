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
        $franjas_horarias = DB::table('franjas_horarias_tabla_maestra')
            ->select('*')
            ->get();
        return $franjas_horarias;
    }

    public static function getFranjaHorariaById($id) {
        $franja_horaria = DB::table('franjas_horarias_tabla_maestra')->where('id', $id)
            ->select('nombre')
            ->first();
        return $franja_horaria;
    }

    public static function create($nombre) {
        $horario = new Horario();
        $horario->nombre = $nombre;
        $horario->save(); 
    
        return $horario->id;
    }

    public static function editarNombreHorario($horario_id, $nombre) {
        $horario = Horario::where('id', $horario_id)->first();
        if ($horario) {
            $horario->nombre = $nombre;
            $horario->save();
    
            return $horario->id;
        } else {
            return null;
        }
    }

    public static function eliminar($id) {
        $horario = Horario::where('id', $id)->delete();
            
        return $horario;
    }

    public static function getFechasHorario($horario_id) {
        $fechas = DB::table('clases_historico')
            ->where('horario_id', $horario_id)
            ->orderBy('fecha')
            ->get();

        return $fechas;
    }

    public static function getFechaId ($fecha) {
        $fecha_id = DB::table('clases_historico')->where('fecha', $fecha)->first();

        return $fecha_id;
    }  

    public static function existeFecha ($fecha) {
        $existeFecha = DB::table('clases_historico')->where('fecha', $fecha)->exists();

        return $existeFecha;
    }          

    public static function actualizarFecha ($horario_id, $fecha) {
        $fecha = DB::table('clases_historico')
            ->where('fecha', $fecha)
            ->update(['horario_id' => $horario_id]);

        return $fecha;
    }    

    public static function crearFecha ($horario_id, $fecha) {
        $fecha = DB::table('clases_historico')
            ->insert([
                'fecha' => $fecha,
                'horario_id' => $horario_id
            ]);
        
        return $fecha;
    }     
}
