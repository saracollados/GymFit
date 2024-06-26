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
            ['fecha' => '2024-01-08', 'horario_id' => '1'],
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
            ['fecha' => '2024-02-29', 'horario_id' => '1'],
            ['fecha' => '2024-03-01', 'horario_id' => '1'],
            ['fecha' => '2024-03-02', 'horario_id' => '1'],
            ['fecha' => '2024-03-03', 'horario_id' => '1'],
            ['fecha' => '2024-03-04', 'horario_id' => '1'],
            ['fecha' => '2024-03-05', 'horario_id' => '1'],
            ['fecha' => '2024-03-06', 'horario_id' => '1'],
            ['fecha' => '2024-03-07', 'horario_id' => '1'],
            ['fecha' => '2024-03-08', 'horario_id' => '1'],
            ['fecha' => '2024-03-09', 'horario_id' => '1'],
            ['fecha' => '2024-03-10', 'horario_id' => '1'],
            ['fecha' => '2024-03-11', 'horario_id' => '1'],
            ['fecha' => '2024-03-12', 'horario_id' => '1'],
            ['fecha' => '2024-03-13', 'horario_id' => '1'],
            ['fecha' => '2024-03-14', 'horario_id' => '1'],
            ['fecha' => '2024-03-15', 'horario_id' => '1'],
            ['fecha' => '2024-03-16', 'horario_id' => '1'],
            ['fecha' => '2024-03-17', 'horario_id' => '1'],
            ['fecha' => '2024-03-18', 'horario_id' => '1'],
            ['fecha' => '2024-03-19', 'horario_id' => '1'],
            ['fecha' => '2024-03-20', 'horario_id' => '1'],
            ['fecha' => '2024-03-21', 'horario_id' => '1'],
            ['fecha' => '2024-03-22', 'horario_id' => '1'],
            ['fecha' => '2024-03-23', 'horario_id' => '1'],
            ['fecha' => '2024-03-24', 'horario_id' => '1'],
            ['fecha' => '2024-03-25', 'horario_id' => '1'],
            ['fecha' => '2024-03-26', 'horario_id' => '1'],
            ['fecha' => '2024-03-27', 'horario_id' => '1'],
            ['fecha' => '2024-03-28', 'horario_id' => '1'],
            ['fecha' => '2024-03-29', 'horario_id' => '1'],
            ['fecha' => '2024-03-30', 'horario_id' => '1'],
            ['fecha' => '2024-03-31', 'horario_id' => '1'],
            ['fecha' => '2024-04-01', 'horario_id' => '1'],
            ['fecha' => '2024-04-02', 'horario_id' => '1'],
            ['fecha' => '2024-04-03', 'horario_id' => '1'],
            ['fecha' => '2024-04-04', 'horario_id' => '1'],
            ['fecha' => '2024-04-05', 'horario_id' => '1'],
            ['fecha' => '2024-04-06', 'horario_id' => '1'],
            ['fecha' => '2024-04-07', 'horario_id' => '1'],
            ['fecha' => '2024-04-08', 'horario_id' => '1'],
            ['fecha' => '2024-04-09', 'horario_id' => '1'],
            ['fecha' => '2024-04-10', 'horario_id' => '1'],
            ['fecha' => '2024-04-11', 'horario_id' => '1'],
            ['fecha' => '2024-04-12', 'horario_id' => '1'],
            ['fecha' => '2024-04-13', 'horario_id' => '1'],
            ['fecha' => '2024-04-14', 'horario_id' => '1'],
            ['fecha' => '2024-04-15', 'horario_id' => '1'],
            ['fecha' => '2024-04-16', 'horario_id' => '1'],
            ['fecha' => '2024-04-17', 'horario_id' => '1'],
            ['fecha' => '2024-04-18', 'horario_id' => '1'],
            ['fecha' => '2024-04-19', 'horario_id' => '1'],
            ['fecha' => '2024-04-20', 'horario_id' => '1'],
            ['fecha' => '2024-04-21', 'horario_id' => '1'],
            ['fecha' => '2024-04-22', 'horario_id' => '1'],
            ['fecha' => '2024-04-23', 'horario_id' => '1'],
            ['fecha' => '2024-04-24', 'horario_id' => '1'],
            ['fecha' => '2024-04-25', 'horario_id' => '1'],
            ['fecha' => '2024-04-26', 'horario_id' => '1'],
            ['fecha' => '2024-04-27', 'horario_id' => '1'],
            ['fecha' => '2024-04-28', 'horario_id' => '1'],
            ['fecha' => '2024-04-29', 'horario_id' => '1'],
            ['fecha' => '2024-04-30', 'horario_id' => '1'],
            ['fecha' => '2024-05-01', 'horario_id' => '1'],
            ['fecha' => '2024-05-02', 'horario_id' => '1'],
            ['fecha' => '2024-05-03', 'horario_id' => '1'],
            ['fecha' => '2024-05-04', 'horario_id' => '1'],
            ['fecha' => '2024-05-05', 'horario_id' => '1'],
            ['fecha' => '2024-05-06', 'horario_id' => '1'],
            ['fecha' => '2024-05-07', 'horario_id' => '1'],
            ['fecha' => '2024-05-08', 'horario_id' => '1'],
            ['fecha' => '2024-05-09', 'horario_id' => '1'],
            ['fecha' => '2024-05-10', 'horario_id' => '1'],
            ['fecha' => '2024-05-11', 'horario_id' => '1'],
            ['fecha' => '2024-05-12', 'horario_id' => '1'],
            ['fecha' => '2024-05-13', 'horario_id' => '1'],
            ['fecha' => '2024-05-14', 'horario_id' => '1'],
            ['fecha' => '2024-05-15', 'horario_id' => '1'],
            ['fecha' => '2024-05-16', 'horario_id' => '1'],
            ['fecha' => '2024-05-17', 'horario_id' => '1'],
            ['fecha' => '2024-05-18', 'horario_id' => '1'],
            ['fecha' => '2024-05-19', 'horario_id' => '1'],
            ['fecha' => '2024-05-20', 'horario_id' => '1'],
            ['fecha' => '2024-05-21', 'horario_id' => '1'],
            ['fecha' => '2024-05-22', 'horario_id' => '1'],
            ['fecha' => '2024-05-23', 'horario_id' => '1'],
            ['fecha' => '2024-05-24', 'horario_id' => '1'],
            ['fecha' => '2024-05-25', 'horario_id' => '1'],
            ['fecha' => '2024-05-26', 'horario_id' => '1'],
            ['fecha' => '2024-05-27', 'horario_id' => '1'],
            ['fecha' => '2024-05-28', 'horario_id' => '1'],
            ['fecha' => '2024-05-29', 'horario_id' => '1'],
            ['fecha' => '2024-05-30', 'horario_id' => '1'],
            ['fecha' => '2024-05-31', 'horario_id' => '1'],
            ['fecha' => '2024-06-01', 'horario_id' => '1'],
            ['fecha' => '2024-06-02', 'horario_id' => '1'],
            ['fecha' => '2024-06-03', 'horario_id' => '1'],
            ['fecha' => '2024-06-04', 'horario_id' => '1'],
            ['fecha' => '2024-06-05', 'horario_id' => '1'],
            ['fecha' => '2024-06-06', 'horario_id' => '1'],
            ['fecha' => '2024-06-07', 'horario_id' => '1'],
            ['fecha' => '2024-06-08', 'horario_id' => '1'],
            ['fecha' => '2024-06-09', 'horario_id' => '1'],
            ['fecha' => '2024-06-10', 'horario_id' => '1'],
            ['fecha' => '2024-06-11', 'horario_id' => '1'],
            ['fecha' => '2024-06-12', 'horario_id' => '1'],
            ['fecha' => '2024-06-13', 'horario_id' => '1'],
            ['fecha' => '2024-06-14', 'horario_id' => '1'],
            ['fecha' => '2024-06-15', 'horario_id' => '1'],
            ['fecha' => '2024-06-16', 'horario_id' => '1'],
            ['fecha' => '2024-06-17', 'horario_id' => '1'],
            ['fecha' => '2024-06-18', 'horario_id' => '1'],
            ['fecha' => '2024-06-19', 'horario_id' => '1'],
            ['fecha' => '2024-06-20', 'horario_id' => '1'],
            ['fecha' => '2024-06-21', 'horario_id' => '1'],
            ['fecha' => '2024-06-22', 'horario_id' => '1'],
            ['fecha' => '2024-06-23', 'horario_id' => '1'],
            ['fecha' => '2024-06-24', 'horario_id' => '1'],
            ['fecha' => '2024-06-25', 'horario_id' => '1'],
            ['fecha' => '2024-06-26', 'horario_id' => '1'],
            ['fecha' => '2024-06-27', 'horario_id' => '1'],
            ['fecha' => '2024-06-28', 'horario_id' => '1'],
            ['fecha' => '2024-06-29', 'horario_id' => '1'],
            ['fecha' => '2024-06-30', 'horario_id' => '1']
        ]);
    }
}
