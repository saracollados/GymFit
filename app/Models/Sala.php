<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;

class Sala extends Model {
    use HasFactory;

    public function clase() {
        return $this->hasMany(Clase::class);
    }

    public function horariosClases() {
        return $this->hasMany(HorarioClase::class, 'sala_id');
    }

    public static function getAll() {
        return Sala::where('activo', 1)->get();
    }

    public static function create(Request $request) {
        $sala = new Sala();
        $sala->nombre = $request->input('nombre');
        $sala->aforo = $request->input('aforo'); 
        $sala->save(); 

        return $sala->id;
    }

    public static function getAforo($sala_id) {
        $aforo = Sala::where('id', $sala_id)
            ->select('aforo')
            ->first()->aforo;

        return $aforo;
    }

    public static function getSalaById($id) {
        return Sala::where('id', $id)->first();
    }

    public static function updateSala($id, $nombre, $aforo) {
        $sala = Sala::find($id);
        $sala->nombre = $nombre;
        $sala->aforo = $aforo;
        $sala->save(); 

        return $sala;
    }

    public static function deleteSala($id) {
        $sala = Sala::find($id);
        $sala->activo = 0;
        $sala->save();
        return $sala;
    }
}