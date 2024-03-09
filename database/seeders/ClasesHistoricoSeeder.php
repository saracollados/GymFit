<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClasesHistoricoSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::statement('ALTER TABLE clases_historico AUTO_INCREMENT = 1');
        DB::table('clases_historico')->insert([
            ['fecha' => '2024-01-01', 'horario_id' => '1'],
            ['fecha' => '2024-01-02', 'horario_id' => '1'],
            ['fecha' => '2024-01-03', 'horario_id' => '1'],
            ['fecha' => '2024-01-04', 'horario_id' => '1'],
            ['fecha' => '2024-01-05', 'horario_id' => '1'],
            ['fecha' => '2024-01-06', 'horario_id' => '1'],
            ['fecha' => '2024-01-07', 'horario_id' => '1'],
            ['fecha' => '2024-01-09', 'horario_id' => '1'],
            ['fecha' => '2024-01-09', 'horario_id' => '1'],
            ['fecha' => '2024-01-10', 'horario_id' => '1'],
            ['fecha' => '2024-01-11', 'horario_id' => '1'],
            ['fecha' => '2024-01-12', 'horario_id' => '1'],
            ['fecha' => '2024-01-13', 'horario_id' => '1'],
            ['fecha' => '2024-01-14', 'horario_id' => '1'],
            ['fecha' => '2024-01-15', 'horario_id' => '1'],
            ['fecha' => '2024-01-16', 'horario_id' => '1'],
            ['fecha' => '2024-01-17', 'horario_id' => '1'],
            ['fecha' => '2024-01-18', 'horario_id' => '1'],
            ['fecha' => '2024-01-19', 'horario_id' => '1'],
            ['fecha' => '2024-01-20', 'horario_id' => '1'],
            ['fecha' => '2024-01-21', 'horario_id' => '1'],
            ['fecha' => '2024-01-22', 'horario_id' => '1'],
            ['fecha' => '2024-01-23', 'horario_id' => '1'],
            ['fecha' => '2024-01-24', 'horario_id' => '1'],
            ['fecha' => '2024-01-25', 'horario_id' => '1'],
            ['fecha' => '2024-01-26', 'horario_id' => '1'],
            ['fecha' => '2024-01-27', 'horario_id' => '1'],
            ['fecha' => '2024-01-28', 'horario_id' => '1'],
            ['fecha' => '2024-01-29', 'horario_id' => '1'],
            ['fecha' => '2024-01-30', 'horario_id' => '1'],
            ['fecha' => '2024-01-31', 'horario_id' => '1'],
            ['fecha' => '2024-02-01', 'horario_id' => '1'],
            ['fecha' => '2024-02-02', 'horario_id' => '1'],
            ['fecha' => '2024-02-03', 'horario_id' => '1'],
            ['fecha' => '2024-02-04', 'horario_id' => '1'],
            ['fecha' => '2024-02-05', 'horario_id' => '1'],
            ['fecha' => '2024-02-06', 'horario_id' => '1'],
            ['fecha' => '2024-02-07', 'horario_id' => '1'],
            ['fecha' => '2024-02-08', 'horario_id' => '1'],
            ['fecha' => '2024-02-09', 'horario_id' => '1'],
            ['fecha' => '2024-02-10', 'horario_id' => '1'],
            ['fecha' => '2024-02-11', 'horario_id' => '1'],
            ['fecha' => '2024-02-12', 'horario_id' => '1'],
            ['fecha' => '2024-02-13', 'horario_id' => '1'],
            ['fecha' => '2024-02-14', 'horario_id' => '1'],
            ['fecha' => '2024-02-15', 'horario_id' => '1'],
            ['fecha' => '2024-02-16', 'horario_id' => '1'],
            ['fecha' => '2024-02-17', 'horario_id' => '1'],
            ['fecha' => '2024-02-18', 'horario_id' => '1'],
            ['fecha' => '2024-02-19', 'horario_id' => '1'],
            ['fecha' => '2024-02-20', 'horario_id' => '1'],
            ['fecha' => '2024-02-21', 'horario_id' => '1'],
            ['fecha' => '2024-02-22', 'horario_id' => '1'],
            ['fecha' => '2024-02-23', 'horario_id' => '1'],
            ['fecha' => '2024-02-24', 'horario_id' => '1'],
            ['fecha' => '2024-02-25', 'horario_id' => '1'],
            ['fecha' => '2024-02-26', 'horario_id' => '1'],
            ['fecha' => '2024-02-27', 'horario_id' => '1'],
            ['fecha' => '2024-02-28', 'horario_id' => '1'],
        ]);
    }
}
