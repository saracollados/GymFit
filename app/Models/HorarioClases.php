<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HorarioClases extends Model {
    use HasFactory;

    // Añadir relaciones con otros modelos!!
    protected $fillable = ['id'];

    protected $table = 'horarios_clases';

    public static function getClasesHorario($horario_id, $monitor_id = null) {
        $clasesHorario = HorarioClases::join ('horarios', 'horarios.id', '=', 'horarios_clases.horario_id')
            ->join ('dias_semana_tabla_maestra', 'dias_semana_tabla_maestra.id', '=', 'horarios_clases.dia_semana_id')
            ->join ('franjas_horarias_tabla_maestra', 'franjas_horarias_tabla_maestra.id', '=', 'horarios_clases.franja_horaria_id')
            ->join ('clases', 'clases.id', '=', 'horarios_clases.clase_id')
            ->join ('personal', 'personal.id', '=', 'horarios_clases.monitor_id')
            ->join ('salas', 'salas.id', '=', 'horarios_clases.sala_id')
            ->select(
                'horarios_clases.id', 
                'horarios_clases.horario_id', 
                'horarios.nombre as horario_nombre', 
                'horarios_clases.dia_semana_id', 
                'dias_semana_tabla_maestra.nombre as dia_semana_nombre',
                'horarios_clases.franja_horaria_id',
                'franjas_horarias_tabla_maestra.nombre as franja_horaria_nombre',
                'horarios_clases.clase_id',
                'clases.nombre as clase_nombre',
                'clases.color',
                'horarios_clases.monitor_id',
                'personal.nombre as monitor_nombre',
                'horarios_clases.sala_id',
                'salas.nombre as sala_nombre')
            ->where('horarios.id', '=', $horario_id)
            ->when($monitor_id, function ($query, $monitor_id) {
                return $query->where('horarios_clases.monitor_id', $monitor_id);
            })
            ->get();

        return $clasesHorario;
    }

    public static function getClaseById($clase_id) {
        $claseHorario = HorarioClases::join ('horarios', 'horarios.id', '=', 'horarios_clases.horario_id')
            ->join ('dias_semana_tabla_maestra', 'dias_semana_tabla_maestra.id', '=', 'horarios_clases.dia_semana_id')
            ->join ('franjas_horarias_tabla_maestra', 'franjas_horarias_tabla_maestra.id', '=', 'horarios_clases.franja_horaria_id')
            ->join ('clases', 'clases.id', '=', 'horarios_clases.clase_id')
            ->join ('personal', 'personal.id', '=', 'horarios_clases.monitor_id')
            ->join ('salas', 'salas.id', '=', 'horarios_clases.sala_id')
            ->select(
                'horarios_clases.id', 
                'horarios_clases.horario_id', 
                'horarios.nombre as horario_nombre', 
                'horarios_clases.dia_semana_id', 
                'dias_semana_tabla_maestra.nombre as dia_semana_nombre',
                'horarios_clases.franja_horaria_id',
                'franjas_horarias_tabla_maestra.nombre as franja_horaria_nombre',
                'horarios_clases.clase_id',
                'clases.nombre as clase_nombre',
                'clases.color',
                'horarios_clases.monitor_id',
                'personal.nombre as monitor_nombre',
                'horarios_clases.sala_id',
                'salas.nombre as sala_nombre')
            ->where('horarios_clases.id', '=', $clase_id)
            ->first();

        return $claseHorario;
    }

    public static function getClasesIdByHorario($horario_id) {
        $clases_id = HorarioClases::where('horario_id', '=', $horario_id)->get('id');

        return $clases_id;
    }

    public static function getClasesByHorarioDia($horario_id, $dia_semana_id, $profesional_id = null) {
        $clasesHorarioDia = HorarioClases::join ('horarios', 'horarios.id', '=', 'horarios_clases.horario_id')
            ->join ('dias_semana_tabla_maestra', 'dias_semana_tabla_maestra.id', '=', 'horarios_clases.dia_semana_id')
            ->join ('franjas_horarias_tabla_maestra', 'franjas_horarias_tabla_maestra.id', '=', 'horarios_clases.franja_horaria_id')
            ->join ('clases', 'clases.id', '=', 'horarios_clases.clase_id')
            ->join ('personal', 'personal.id', '=', 'horarios_clases.monitor_id')
            ->join ('salas', 'salas.id', '=', 'horarios_clases.sala_id')
            ->select(
                'horarios_clases.id', 
                'horarios_clases.horario_id', 
                'horarios.nombre as horario_nombre', 
                'horarios_clases.dia_semana_id', 
                'dias_semana_tabla_maestra.nombre as dia_semana_nombre',
                'horarios_clases.franja_horaria_id',
                'franjas_horarias_tabla_maestra.nombre as franja_horaria_nombre',
                'horarios_clases.clase_id',
                'clases.nombre as clase_nombre',
                'clases.color',
                'horarios_clases.monitor_id',
                'personal.nombre as monitor_nombre',
                'horarios_clases.sala_id',
                'salas.nombre as sala_nombre')
            ->where('horarios_clases.horario_id', '=', $horario_id)
            ->where('horarios_clases.dia_semana_id', '=', $dia_semana_id)
            ->when($profesional_id, function ($query, $profesional_id) {
                return $query->where('horarios_clases.monitor_id', $profesional_id);
            })
            ->get();

        return $clasesHorarioDia;
    }
    
    public static function getDiasSemana() {
        $diasSemana = DB::table('dias_semana_tabla_maestra')
            ->select('*')
            ->get();
        return $diasSemana;
    }

    public static function getFranjasHorarias() {
        $diasSemana = DB::table('franjas_horarias_tabla_maestra')
            ->select('*')
            ->get();
        return $diasSemana;
    }

    public static function duplicarClasesHorario($horario_duplicar_id, $horario_nuevo_id) {
        $clases = HorarioClases::getClasesIdByHorario($horario_duplicar_id);

        foreach($clases as $clase) {
            $clase_original = HorarioClases::find($clase['id']);
            if($clase_original) {
                $clase_nueva = new HorarioClases;
                $clase_nueva = $clase_original->replicate();
                $clase_nueva['horario_id'] = $horario_nuevo_id;
                $clase_nueva->save();
            }
        }
    }

    public static function create(Request $request) {
        $clase = new HorarioClases();
        $clase->horario_id = $request->input('horario_id');
        $clase->dia_semana_id = $request->input('dia_semana_id');
        $clase->franja_horaria_id = $request->input('franja_horaria_id');
        $clase->clase_id = $request->input('clase_id');
        $clase->monitor_id = $request->input('monitor_id');
        $clase->sala_id = $request->input('sala_id');
        $clase->save(); 

        return $clase->id;
    }

    public static function eliminarClase($id) {
        $clase = HorarioClases::find($id);
        $clase->delete();
        return $clase;
    }
}
