<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;

class Clase extends Model {
    use HasFactory;

    public function sala() {
        return $this->belongsTo(Sala::class);
    }
    public function monitor() {
        return $this->belongsTo(Personal::class);
    }
    public function reserva() {
        return $this->hasMany(Reserva::class);
    }
    public function horario() {
        return $this->belongsTo(Horario::class);
    }

    public static function getAll() {
        return Clase::all();
    }

    public static function create(Request $request) {
        $clase = new Clase();
        $clase->nombre = $request->input('nombre');
        $clase->descripcion = $request->input('descripcion');
        $clase->color = $request->input('color');
        $clase->save(); 

        return $clase->id;
    }
}
