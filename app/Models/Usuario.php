<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// class Usuario extends Model {
class Usuario extends Authenticatable {
    use HasFactory;
    use Notifiable;

    public function reserva() {
        return $this->hasMany(Reserva::class);
    }

    public static function getAll() {
        $usuarios = Usuario::join('generos_tabla_maestra', 'usuarios.genero_id', '=', 'generos_tabla_maestra.id')
            ->select('usuarios.id', 'usuarios.dni', 'usuarios.nombre', 'generos_tabla_maestra.id as genero_id', 'generos_tabla_maestra.nombre as genero', 'usuarios.fecha_nacimiento', 'usuarios.email', 'usuarios.password')
            ->get();
        
        return $usuarios;
    }

    public static function getGeneros() {
        $generos = DB::table('generos_tabla_maestra')
            ->select('*')
            ->get();
        return $generos;
    }

    public static function create(Request $request) {
        $usuario = new Usuario();
        $usuario->dni = $request->input('dni');
        $usuario->nombre = $request->input('nombre');
        $usuario->genero_id = $request->input('genero_id'); 
        $usuario->fecha_nacimiento = $request->input('fecha_nacimiento');
        $usuario->email = $request->input('email');
        $usuario->password = $request->input('password');
        $usuario->save(); 

        return $usuario->id;
    }

    public static function getUsuarioById($usuario_id) {
        $usuario = Usuario::select('id', 'dni', 'nombre')
            ->where('id', '=', $usuario_id)
            ->first();
        
        return $usuario;
    }
}
