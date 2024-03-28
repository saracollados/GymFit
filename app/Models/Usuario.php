<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Usuario extends Authenticatable {
    use HasFactory;
    use Notifiable;

    public function reserva() {
        return $this->hasMany(Reserva::class);
    }

    public static function getAll() {
        $usuarios = Usuario::join('generos_tabla_maestra', 'usuarios.genero_id', '=', 'generos_tabla_maestra.id')
            ->select('usuarios.id', 'usuarios.dni', 'usuarios.nombre', 'generos_tabla_maestra.id as genero_id', 'generos_tabla_maestra.nombre as genero', 'usuarios.fecha_nacimiento', 'usuarios.email', 'usuarios.password')
            ->where('activo', 1)
            ->get();
        
        return $usuarios;
    }

    public static function countUsuariosActivos() {
        $count = Usuario::where('activo', 1)->count();
        
        return $count;
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
        $usuario->password = $request->input('dni');
        $usuario->save(); 

        return $usuario->id;
    }

    public static function getUsuarioInfoSession($usuario_id) {
        $usuario = Usuario::select('id', 'dni', 'nombre', 'email', 'password', 'genero_id', 'fecha_nacimiento')
            ->where('id', '=', $usuario_id)
            ->first();
        
        return $usuario;
    }

    public static function getUsuarioById($usuario_id) {
        $usuario = Usuario::join('generos_tabla_maestra', 'usuarios.genero_id', '=', 'generos_tabla_maestra.id')
            ->select('usuarios.id as id', 'usuarios.dni as dni', 'usuarios.nombre as nombre', 'usuarios.email as email', 'usuarios.password as password', 'usuarios.genero_id as genero_id', 'generos_tabla_maestra.nombre as genero_nombre', 'usuarios.fecha_nacimiento as fecha_nacimiento')
            ->where('usuarios.id', '=', $usuario_id)
            ->first();
        
        return $usuario;
    }

    public static function updateUsuario($id, $nombre, $fecha_nacimiento, $email, $genero_id, $password = null) {
        $usuario = Usuario::find($id);
        $usuario->nombre = $nombre;
        $usuario->fecha_nacimiento = $fecha_nacimiento;
        $usuario->email = $email;
        $usuario->genero_id = $genero_id;
        if($password) {
            $usuario->password = $password;
        }
        $usuario->save(); 

        return $usuario;
    }

    public static function deleteUsuario($id) {
        $usuario = Usuario::find($id);
        $usuario->activo = 0;
        $usuario->save();
        return $usuario;
    }

    public static function existsUsuarioDni($dni) {
        $usuario = Usuario::where('dni', $dni)
            ->where('activo', 1)
            ->first();
        return $usuario;
    }
}
