<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ReservasServiciosSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::statement('ALTER TABLE reservas_servicios AUTO_INCREMENT = 1');
        DB::table('reservas_servicios')->insert([
            ['usuario_id' => '14', 'servicio_id' => '2'],
            ['usuario_id' => '19', 'servicio_id' => '4'],
            ['usuario_id' => '5', 'servicio_id' => '5'],
            ['usuario_id' => '11', 'servicio_id' => '6'],
            ['usuario_id' => '16', 'servicio_id' => '7'],
            ['usuario_id' => '9', 'servicio_id' => '8'],
            ['usuario_id' => '3', 'servicio_id' => '10'],
            ['usuario_id' => '18', 'servicio_id' => '11'],
            ['usuario_id' => '4', 'servicio_id' => '14'],
            ['usuario_id' => '21', 'servicio_id' => '15'],
            ['usuario_id' => '1', 'servicio_id' => '16'],
            ['usuario_id' => '12', 'servicio_id' => '17'],
            ['usuario_id' => '17', 'servicio_id' => '18'],
            ['usuario_id' => '8', 'servicio_id' => '19'],
            ['usuario_id' => '22', 'servicio_id' => '20'],
            ['usuario_id' => '2', 'servicio_id' => '21'],
            ['usuario_id' => '14', 'servicio_id' => '22'],
            ['usuario_id' => '19', 'servicio_id' => '24'],
            ['usuario_id' => '5', 'servicio_id' => '25'],
            ['usuario_id' => '11', 'servicio_id' => '26'],
            ['usuario_id' => '9', 'servicio_id' => '28'],
            ['usuario_id' => '23', 'servicio_id' => '29'],
            ['usuario_id' => '3', 'servicio_id' => '30'],
            ['usuario_id' => '18', 'servicio_id' => '31'],
            ['usuario_id' => '6', 'servicio_id' => '32'],
            ['usuario_id' => '13', 'servicio_id' => '33'],
            ['usuario_id' => '21', 'servicio_id' => '35'],
            ['usuario_id' => '1', 'servicio_id' => '36'],
            ['usuario_id' => '12', 'servicio_id' => '37'],
            ['usuario_id' => '17', 'servicio_id' => '38'],
            ['usuario_id' => '8', 'servicio_id' => '39'],
            ['usuario_id' => '2', 'servicio_id' => '41'],
            ['usuario_id' => '14', 'servicio_id' => '42'],
            ['usuario_id' => '7', 'servicio_id' => '43'],
            ['usuario_id' => '19', 'servicio_id' => '44'],
            ['usuario_id' => '11', 'servicio_id' => '46'],
            ['usuario_id' => '16', 'servicio_id' => '47'],
            ['usuario_id' => '9', 'servicio_id' => '48'],
            ['usuario_id' => '23', 'servicio_id' => '49'],
            ['usuario_id' => '3', 'servicio_id' => '50'],
            ['usuario_id' => '18', 'servicio_id' => '51'],
            ['usuario_id' => '6', 'servicio_id' => '52'],
            ['usuario_id' => '13', 'servicio_id' => '53'],
            ['usuario_id' => '4', 'servicio_id' => '54'],
            ['usuario_id' => '21', 'servicio_id' => '55'],
            ['usuario_id' => '12', 'servicio_id' => '57'],
            ['usuario_id' => '22', 'servicio_id' => '60'],
            ['usuario_id' => '2', 'servicio_id' => '61'],
            ['usuario_id' => '14', 'servicio_id' => '62'],
            ['usuario_id' => '7', 'servicio_id' => '63'],
            ['usuario_id' => '19', 'servicio_id' => '64'],
            ['usuario_id' => '5', 'servicio_id' => '65'],
            ['usuario_id' => '11', 'servicio_id' => '66'],
        ]);
    }
}
