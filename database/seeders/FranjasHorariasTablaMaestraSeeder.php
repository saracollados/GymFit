<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FranjasHorariasTablaMaestraSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::table('franjas_horarias_tabla_maestra')->insert([
            ['id' => '1', 'nombre' => '6-7'],
            ['id' => '2', 'nombre' => '7-8'],
            ['id' => '3', 'nombre' => '8-9'],
            ['id' => '4', 'nombre' => '9-10'],
            ['id' => '5', 'nombre' => '10-11'],
            ['id' => '6', 'nombre' => '11-12'],
            ['id' => '7', 'nombre' => '12-13'],
            ['id' => '8', 'nombre' => '13-14'],
            ['id' => '9', 'nombre' => '14-15'],
            ['id' => '10', 'nombre' => '15-16'],
            ['id' => '11', 'nombre' => '16-17'],
            ['id' => '12', 'nombre' => '17-18'],
            ['id' => '13', 'nombre' => '18-19'],
            ['id' => '14', 'nombre' => '19-20'],
            ['id' => '15', 'nombre' => '20-21'],
            ['id' => '16', 'nombre' => '21-22']
        ]);
    }
}
