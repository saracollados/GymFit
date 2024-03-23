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
        return Clase::where('activo', 1)->get();
    }

    public static function getClaseById($id) {
        return Clase::where('id', $id)->first();
    }

    public static function create($nombre, $descripcion, $color) {
        $clase = new Clase();
        $clase->nombre = $nombre;
        $clase->descripcion = $descripcion;
        $clase->color = $color;
        $clase->save(); 

        return $clase->id;
    }

    public static function updateClase($id, $nombre, $descripcion, $color) {
        $clase = Clase::find($id);
        $clase->nombre = $nombre;
        $clase->descripcion = $descripcion;
        $clase->color = $color;
        $clase->save(); 

        return $clase;
    }

    public static function deleteClase($id) {
        $clase = Clase::find($id);
        $clase->activo = 0;
        $clase->save();
        return $clase;
    }
}
