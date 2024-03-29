<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Personal extends Authenticatable {
    use HasFactory;
    use Notifiable;

    public function clase() {
        return $this->hasMany(Clase::class);
    }

    public function horariosClases() {
        return $this->hasMany(HorarioClase::class, 'monitor_id');
    }

    protected $table = 'personal';

    public static function getAll() {
        $personal = Personal::join('roles_personal_tabla_maestra', 'personal.role_id', '=', 'roles_personal_tabla_maestra.id')
            ->select('personal.id','personal.dni', 'personal.nombre', 'roles_personal_tabla_maestra.id as role_id', 'roles_personal_tabla_maestra.nombre as role', 'personal.email', 'personal.password')
            ->where('activo', 1)
            ->get();
        
        return $personal;
    }

    public static function countPersonalActivos($role_id = null) {
        $count = Personal::where('activo', 1)
        ->when($role_id, function ($query, $role_id) {
            return $query->where('role_id', $role_id);
        })
        ->count();
        
        return $count;
    }

    public static function create(Request $request) {
        $personal = new Personal();
        $personal->nombre = $request->input('nombre');
        $personal->dni = $request->input('dni');
        $personal->role_id = $request->input('role'); 
        $personal->email = $request->input('email');
        $personal->password = $request->input('dni');
        $personal->save(); 

        return $personal->id;
    }

    public static function getRoles() {
        $roles = DB::table('roles_personal_tabla_maestra')
            ->select('*')
            ->get();
        return $roles;
    }

    public static function getPersonalByRole($role_id, $role_id2 = null) {
        $query = Personal::join('roles_personal_tabla_maestra', 'personal.role_id', '=', 'roles_personal_tabla_maestra.id')
        ->select('personal.id', 'personal.dni', 'personal.nombre', 'roles_personal_tabla_maestra.id as role_id', 'roles_personal_tabla_maestra.nombre as role', 'personal.email', 'personal.password');

        if ($role_id2 !== null) {
            $personal = $query->whereIn('personal.role_id', [$role_id, $role_id2])->get();
        } else {
            $personal = $query->where('personal.role_id', '=', $role_id)->get();
        }

        return $personal;
    }

    public static function getPersonalInfoSession($personal_id) {
        $personal = Personal::select('id', 'dni', 'nombre', 'role_id', 'email', 'password')
            ->where('id', '=', $personal_id)
            ->first();
        return $personal;
    }

    public static function getPersonalById($personal_id) {
        $personal = Personal::join('roles_personal_tabla_maestra', 'personal.role_id', '=', 'roles_personal_tabla_maestra.id')
            ->select('personal.id', 'personal.dni', 'personal.nombre', 'roles_personal_tabla_maestra.id as role_id', 'roles_personal_tabla_maestra.nombre as role', 'personal.email', 'personal.password')
            ->where('personal.id', '=', $personal_id)
            ->first();
        return $personal;
    }

    public static function updatePersonal($id, $nombre, $email, $password = null) {
        $personal = Personal::find($id);
        $personal->nombre = $nombre;
        $personal->email = $email;
        if($password) {
            $personal->password = $password;
        }
        $personal->save(); 

        return $personal;
    }

    public static function deletePersonal($id) {
        $personal = Personal::find($id);
        $personal->activo = 0;
        $personal->save();
        return $personal;
    }
}
