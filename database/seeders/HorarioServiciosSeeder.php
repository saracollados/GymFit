<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HorarioServiciosSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::statement('ALTER TABLE horarios_servicios AUTO_INCREMENT = 1');
        DB::table('horarios_servicios')->insert([
            ['personal_id' => '2', 'fecha' => '2024-03-25', 'franja_horaria_id' => '8'],
            ['personal_id' => '5', 'fecha' => '2024-04-10', 'franja_horaria_id' => '3'],
            ['personal_id' => '9', 'fecha' => '2024-05-15', 'franja_horaria_id' => '12'],
            ['personal_id' => '2', 'fecha' => '2024-06-20', 'franja_horaria_id' => '5'],
            ['personal_id' => '10', 'fecha' => '2024-03-30', 'franja_horaria_id' => '9'],
            ['personal_id' => '5', 'fecha' => '2024-05-05', 'franja_horaria_id' => '7'],
            ['personal_id' => '2', 'fecha' => '2024-04-05', 'franja_horaria_id' => '6'],
            ['personal_id' => '5', 'fecha' => '2024-03-20', 'franja_horaria_id' => '10'],
            ['personal_id' => '9', 'fecha' => '2024-04-15', 'franja_horaria_id' => '2'],
            ['personal_id' => '10', 'fecha' => '2024-06-10', 'franja_horaria_id' => '14'],
            ['personal_id' => '2', 'fecha' => '2024-05-20', 'franja_horaria_id' => '3'],
            ['personal_id' => '5', 'fecha' => '2024-04-30', 'franja_horaria_id' => '8'],
            ['personal_id' => '9', 'fecha' => '2024-05-25', 'franja_horaria_id' => '12'],
            ['personal_id' => '10', 'fecha' => '2024-06-15', 'franja_horaria_id' => '5'],
            ['personal_id' => '2', 'fecha' => '2024-03-28', 'franja_horaria_id' => '9'],
            ['personal_id' => '5', 'fecha' => '2024-04-12', 'franja_horaria_id' => '4'],
            ['personal_id' => '9', 'fecha' => '2024-06-05', 'franja_horaria_id' => '7'],
            ['personal_id' => '10', 'fecha' => '2024-03-22', 'franja_horaria_id' => '11'],
            ['personal_id' => '2', 'fecha' => '2024-05-10', 'franja_horaria_id' => '13'],
            ['personal_id' => '5', 'fecha' => '2024-06-25', 'franja_horaria_id' => '16'],
            ['personal_id' => '9', 'fecha' => '2024-03-15', 'franja_horaria_id' => '1'],
            ['personal_id' => '10', 'fecha' => '2024-04-20', 'franja_horaria_id' => '15'],
            ['personal_id' => '2', 'fecha' => '2024-05-30', 'franja_horaria_id' => '2'],
            ['personal_id' => '5', 'fecha' => '2024-06-20', 'franja_horaria_id' => '11'],
            ['personal_id' => '9', 'fecha' => '2024-03-25', 'franja_horaria_id' => '6'],
            ['personal_id' => '10', 'fecha' => '2024-04-10', 'franja_horaria_id' => '8'],
            ['personal_id' => '2', 'fecha' => '2024-04-10', 'franja_horaria_id' => '7'],
            ['personal_id' => '5', 'fecha' => '2024-05-05', 'franja_horaria_id' => '14'],
            ['personal_id' => '9', 'fecha' => '2024-06-20', 'franja_horaria_id' => '3'],
            ['personal_id' => '10', 'fecha' => '2024-03-30', 'franja_horaria_id' => '12'],
            ['personal_id' => '2', 'fecha' => '2024-05-15', 'franja_horaria_id' => '5'],
            ['personal_id' => '5', 'fecha' => '2024-06-10', 'franja_horaria_id' => '2'],
            ['personal_id' => '9', 'fecha' => '2024-03-20', 'franja_horaria_id' => '11'],
            ['personal_id' => '10', 'fecha' => '2024-04-05', 'franja_horaria_id' => '8'],
            ['personal_id' => '2', 'fecha' => '2024-05-25', 'franja_horaria_id' => '13'],
            ['personal_id' => '5', 'fecha' => '2024-06-15', 'franja_horaria_id' => '4'],
            ['personal_id' => '9', 'fecha' => '2024-03-25', 'franja_horaria_id' => '9'],
            ['personal_id' => '10', 'fecha' => '2024-04-15', 'franja_horaria_id' => '16'],
            ['personal_id' => '2', 'fecha' => '2024-05-05', 'franja_horaria_id' => '1'],
            ['personal_id' => '5', 'fecha' => '2024-06-01', 'franja_horaria_id' => '10'],
            ['personal_id' => '9', 'fecha' => '2024-03-15', 'franja_horaria_id' => '15'],
            ['personal_id' => '10', 'fecha' => '2024-04-20', 'franja_horaria_id' => '6'],
            ['personal_id' => '2', 'fecha' => '2024-05-10', 'franja_horaria_id' => '11'],
            ['personal_id' => '5', 'fecha' => '2024-06-05', 'franja_horaria_id' => '3'],
            ['personal_id' => '9', 'fecha' => '2024-03-28', 'franja_horaria_id' => '12'],
            ['personal_id' => '10', 'fecha' => '2024-04-25', 'franja_horaria_id' => '7'],
            ['personal_id' => '2', 'fecha' => '2024-05-20', 'franja_horaria_id' => '9'],
            ['personal_id' => '5', 'fecha' => '2024-06-25', 'franja_horaria_id' => '1'],
            ['personal_id' => '9', 'fecha' => '2024-03-23', 'franja_horaria_id' => '6'],
            ['personal_id' => '10', 'fecha' => '2024-04-10', 'franja_horaria_id' => '13'],
            ['personal_id' => '2', 'fecha' => '2024-05-30', 'franja_horaria_id' => '10'],
            ['personal_id' => '5', 'fecha' => '2024-06-20', 'franja_horaria_id' => '2'],
            ['personal_id' => '9', 'fecha' => '2024-03-18', 'franja_horaria_id' => '7'],
            ['personal_id' => '10', 'fecha' => '2024-04-15', 'franja_horaria_id' => '14'],
            ['personal_id' => '2', 'fecha' => '2024-05-05', 'franja_horaria_id' => '3'],
            ['personal_id' => '5', 'fecha' => '2024-06-10', 'franja_horaria_id' => '11'],
            ['personal_id' => '9', 'fecha' => '2024-03-28', 'franja_horaria_id' => '8'],
            ['personal_id' => '10', 'fecha' => '2024-04-20', 'franja_horaria_id' => '15'],
            ['personal_id' => '2', 'fecha' => '2024-05-15', 'franja_horaria_id' => '4'],
            ['personal_id' => '5', 'fecha' => '2024-06-05', 'franja_horaria_id' => '12'],
            ['personal_id' => '9', 'fecha' => '2024-03-25', 'franja_horaria_id' => '9'],
            ['personal_id' => '10', 'fecha' => '2024-04-30', 'franja_horaria_id' => '16'],
            ['personal_id' => '2', 'fecha' => '2024-05-10', 'franja_horaria_id' => '5'],
            ['personal_id' => '5', 'fecha' => '2024-06-15', 'franja_horaria_id' => '13'],
            ['personal_id' => '9', 'fecha' => '2024-03-20', 'franja_horaria_id' => '10'],
            ['personal_id' => '10', 'fecha' => '2024-04-05', 'franja_horaria_id' => '1']
        ]);
    }
}
