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

    public static function getAll() {
        return Sala::all();
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
}