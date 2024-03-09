<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::statement('ALTER TABLE usuarios AUTO_INCREMENT = 1');
        DB::table('usuarios')->insert([
            ['dni' => '50581953P', 'nombre' => 'Sara Collados', 'genero_id' => '2', 'fecha_nacimiento' => '1986-02-28', 'email' => 'scollados@gmail.com', 'password' => Hash::make('1234')],
            ['dni' => '21823807G', 'nombre' => 'Laura González', 'genero_id' => '2', 'fecha_nacimiento' => '1976-10-07', 'email' => 'lgonzalez@gmail.com', 'password' => Hash::make('1234')],
            ['dni' => '98578569V', 'nombre' => 'Alberto Pérez', 'genero_id' => '1', 'fecha_nacimiento' => '1978-08-18', 'email' => 'aperez@gmail.com', 'password' => Hash::make('1234')],
            ['dni' => '28219778C', 'nombre' => 'María García', 'genero_id' => '2', 'fecha_nacimiento' => '2005-10-14', 'email' => 'mgarcia@gmail.com', 'password' => Hash::make('1234')],
            ['dni' => '43529327X', 'nombre' => 'Carmen Rodríguez', 'genero_id' => '2', 'fecha_nacimiento' => '1982-03-02', 'email' => 'crodriguez@gmail.com', 'password' => Hash::make('1234')],
            ['dni' => '82601411Q', 'nombre' => 'Ana Rodríguez', 'genero_id' => '2', 'fecha_nacimiento' => '2003-02-10', 'email' => 'arodriguez@gmail.com', 'password' => Hash::make('1234')],
            ['dni' => '03919445S', 'nombre' => 'Laura Hernández', 'genero_id' => '2', 'fecha_nacimiento' => '1995-06-01', 'email' => 'lhernandez@gmail.com', 'password' => Hash::make('1234')],
            ['dni' => '05115141X', 'nombre' => 'Antonio Álvarez', 'genero_id' => '1', 'fecha_nacimiento' => '1983-09-27', 'email' => 'analvarez@gmail.com', 'password' => Hash::make('1234')],
            ['dni' => '16787864A', 'nombre' => 'Manuel García', 'genero_id' => '1', 'fecha_nacimiento' => '2003-01-06', 'email' => 'magarcia@gmail.com', 'password' => Hash::make('1234')],
            ['dni' => '63640312W', 'nombre' => 'José Alonso', 'genero_id' => '1', 'fecha_nacimiento' => ' 1981-11-05', 'email' => 'falonse@gmail.com', 'password' => Hash::make('1234')],
            ['dni' => '21265369Y', 'nombre' => 'Francisco Ramos', 'genero_id' => '1', 'fecha_nacimiento' => '1992-02-06', 'email' => 'framos@gmail.com', 'password' => Hash::make('1234')],
            ['dni' => '32299397Z', 'nombre' => 'Javier Delgado', 'genero_id' => '1', 'fecha_nacimiento' => '1975-09-04', 'email' => 'jdelgado@gmail.com', 'password' => Hash::make('1234')],
            ['dni' => '72116386R', 'nombre' => 'Jorge Hernández', 'genero_id' => '1', 'fecha_nacimiento' => '1983-04-12', 'email' => 'jgernandez@gmail.com', 'password' => Hash::make('1234')],
            ['dni' => '59010898M', 'nombre' => 'Alejandra Álvarez', 'genero_id' => '2', 'fecha_nacimiento' => '2000-02-23', 'email' => 'aalvarez@gmail.com', 'password' => Hash::make('1234')],
            ['dni' => '91815861E', 'nombre' => 'Pedro García', 'genero_id' => '1', 'fecha_nacimiento' => '1979-11-29', 'email' => 'pgarcia@gmail.com', 'password' => Hash::make('1234')],
            ['dni' => '91039233N', 'nombre' => 'Luis Rodríguez', 'genero_id' => '1', 'fecha_nacimiento' => '2004-03-24', 'email' => 'lrodriguez@gmail.com', 'password' => Hash::make('1234')],
            ['dni' => '79733666A', 'nombre' => 'Alberto Ramos', 'genero_id' => '1', 'fecha_nacimiento' => '1997-04-09', 'email' => 'aramoz@gmail.com', 'password' => Hash::make('1234')],
            ['dni' => '98685864V', 'nombre' => 'Juan Alonso', 'genero_id' => '1', 'fecha_nacimiento' => '2000-09-30', 'email' => 'jalonso@gmail.com', 'password' => Hash::make('1234')],
            ['dni' => '75833640H', 'nombre' => 'Miguel Delgado', 'genero_id' => '1', 'fecha_nacimiento' => '1988-02-10', 'email' => 'mdelgado@gmail.com', 'password' => Hash::make('1234')],
            ['dni' => '67876660A', 'nombre' => 'Patricia Rodríguez', 'genero_id' => '2', 'fecha_nacimiento' => '1992-10-04', 'email' => 'prodriguez@gmail.com', 'password' => Hash::make('1234')],
            ['dni' => '03521493D', 'nombre' => 'Sara Delgado', 'genero_id' => '2', 'fecha_nacimiento' => '1977-07-26', 'email' => 'sdelgado@gmail.com', 'password' => Hash::make('1234')],
            ['dni' => '21545483A', 'nombre' => 'Adrián Hernández', 'genero_id' => '1', 'fecha_nacimiento' => '1974-05-04', 'email' => 'ahernandez@gmail.com', 'password' => Hash::make('1234')],
            ['dni' => '92647348J', 'nombre' => 'Samuel González', 'genero_id' => '1', 'fecha_nacimiento' => '1996-12-23', 'email' => 'sgonzalez@gmail.com', 'password' => Hash::make('1234')],
        ]);
    }
}

