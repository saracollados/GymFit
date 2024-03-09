<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservasSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::statement('ALTER TABLE reservas AUTO_INCREMENT = 1');
        DB::table('reservas')->insert([
            ['usuario_id' => '19', 'clase_id' => '67', 'fecha_id' => '47'],
            ['usuario_id' => '21', 'clase_id' => '13', 'fecha_id' => '36'],
            ['usuario_id' => '17', 'clase_id' => '57', 'fecha_id' => '40'],
            ['usuario_id' => '9', 'clase_id' => '66', 'fecha_id' => '54'],
            ['usuario_id' => '5', 'clase_id' => '6', 'fecha_id' => '8'],
            ['usuario_id' => '15', 'clase_id' => '71', 'fecha_id' => '20'],
            ['usuario_id' => '9', 'clase_id' => '34', 'fecha_id' => '31'],
            ['usuario_id' => '18', 'clase_id' => '56', 'fecha_id' => '46'],
            ['usuario_id' => '18', 'clase_id' => '45', 'fecha_id' => '11'],
            ['usuario_id' => '7', 'clase_id' => '72', 'fecha_id' => '48'],
            ['usuario_id' => '20', 'clase_id' => '69', 'fecha_id' => '33'],
            ['usuario_id' => '12', 'clase_id' => '14', 'fecha_id' => '57'],
            ['usuario_id' => '2', 'clase_id' => '40', 'fecha_id' => '52'],
            ['usuario_id' => '21', 'clase_id' => '61', 'fecha_id' => '19'],
            ['usuario_id' => '17', 'clase_id' => '27', 'fecha_id' => '37'],
            ['usuario_id' => '5', 'clase_id' => '2', 'fecha_id' => '1'],
            ['usuario_id' => '14', 'clase_id' => '48', 'fecha_id' => '32'],
            ['usuario_id' => '23', 'clase_id' => '36', 'fecha_id' => '38'],
            ['usuario_id' => '22', 'clase_id' => '17', 'fecha_id' => '9'],
            ['usuario_id' => '4', 'clase_id' => '34', 'fecha_id' => '3'],
            ['usuario_id' => '19', 'clase_id' => '6', 'fecha_id' => '8'],
            ['usuario_id' => '7', 'clase_id' => '72', 'fecha_id' => '55'],
            ['usuario_id' => '14', 'clase_id' => '18', 'fecha_id' => '2'],
            ['usuario_id' => '11', 'clase_id' => '46', 'fecha_id' => '53'],
            ['usuario_id' => '19', 'clase_id' => '57', 'fecha_id' => '33'],
            ['usuario_id' => '15', 'clase_id' => '10', 'fecha_id' => '15'],
            ['usuario_id' => '8', 'clase_id' => '74', 'fecha_id' => '13'],
            ['usuario_id' => '7', 'clase_id' => '64', 'fecha_id' => '12'],
            ['usuario_id' => '21', 'clase_id' => '24', 'fecha_id' => '16'],
            ['usuario_id' => '14', 'clase_id' => '22', 'fecha_id' => '23'],
            ['usuario_id' => '4', 'clase_id' => '8', 'fecha_id' => '15'],
            ['usuario_id' => '12', 'clase_id' => '45', 'fecha_id' => '4'],
            ['usuario_id' => '5', 'clase_id' => '23', 'fecha_id' => '44'],
            ['usuario_id' => '22', 'clase_id' => '31', 'fecha_id' => '10'],
            ['usuario_id' => '1', 'clase_id' => '21', 'fecha_id' => '2'],
            ['usuario_id' => '16', 'clase_id' => '3', 'fecha_id' => '1'],
            ['usuario_id' => '14', 'clase_id' => '14', 'fecha_id' => '50'],
            ['usuario_id' => '4', 'clase_id' => '10', 'fecha_id' => '22'],
            ['usuario_id' => '14', 'clase_id' => '13', 'fecha_id' => '43'],
            ['usuario_id' => '4', 'clase_id' => '61', 'fecha_id' => '5'],
            ['usuario_id' => '7', 'clase_id' => '12', 'fecha_id' => '29'],
            ['usuario_id' => '19', 'clase_id' => '54', 'fecha_id' => '11'],
            ['usuario_id' => '17', 'clase_id' => '38', 'fecha_id' => '59'],
            ['usuario_id' => '11', 'clase_id' => '53', 'fecha_id' => '18'],
            ['usuario_id' => '15', 'clase_id' => '25', 'fecha_id' => '44'],
            ['usuario_id' => '21', 'clase_id' => '23', 'fecha_id' => '51'],
            ['usuario_id' => '18', 'clase_id' => '40', 'fecha_id' => '17'],
            ['usuario_id' => '10', 'clase_id' => '11', 'fecha_id' => '22'],
            ['usuario_id' => '22', 'clase_id' => '47', 'fecha_id' => '39'],
            ['usuario_id' => '11', 'clase_id' => '11', 'fecha_id' => '29']
        ]);
    }
}
