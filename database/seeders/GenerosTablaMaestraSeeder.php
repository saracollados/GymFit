<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenerosTablaMaestraSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::table('generos_tabla_maestra')->insert([
            ['id' => '1', 'nombre' => 'Hombre'],
            ['id' => '2', 'nombre' => 'Mujer']
        ]);
    }
}
