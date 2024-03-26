<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesPersonalTablaMaestraSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::table('roles_personal_tabla_maestra')->insert([
            ['id' => '1', 'nombre' => 'Administrador'],
            ['id' => '2', 'nombre' => 'Monitor'],
            ['id' => '3', 'nombre' => 'Nutricionista'],
            ['id' => '4', 'nombre' => 'Fisioterapeuta']
        ]);
    }
}
