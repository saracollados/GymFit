<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// class Personal extends Model {
class Personal extends Authenticatable {
    use HasFactory;
    use Notifiable;

    public function clase() {
        return $this->hasMany(Clase::class);
    }

    protected $table = 'personal';

    public static function getAll() {
        $personal = Personal::join('roles_personal_tabla_maestra', 'personal.role_id', '=', 'roles_personal_tabla_maestra.id')
            ->select('personal.id', 'personal.nombre', 'roles_personal_tabla_maestra.id as role_id', 'roles_personal_tabla_maestra.nombre as role', 'personal.email', 'personal.password')
            ->get();
        
        return $personal;
    }

    public static function create(Request $request) {
        $personal = new Personal();
        $personal->nombre = $request->input('nombre');
        $personal->role_id = $request->input('role'); 
        $personal->email = $request->input('email');
        $personal->password = $request->input('password');
        $personal->save(); 

        return $personal->id;
    }

    public static function getPersonal($id) {
        $personal = Personal::join('roles_personal_tabla_maestra', 'personal.role_id', '=', 'roles_personal_tabla_maestra.id')
            ->select('personal.id', 'personal.nombre', 'roles_personal_tabla_maestra.id as role_id', 'roles_personal_tabla_maestra.nombre as role', 'personal.email', 'personal.password')
            ->where('personal.role_id', '=', $id)
            ->get();
        return $personal;
    }
}
