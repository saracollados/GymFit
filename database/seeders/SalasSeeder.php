<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalasSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::statement('ALTER TABLE salas AUTO_INCREMENT = 1');
        DB::table('salas')->insert([
            ['nombre' => 'Sala 1', 'aforo' => '25'],
            ['nombre' => 'Sala 2', 'aforo' => '16'],
            ['nombre' => 'Spinning', 'aforo' => '20']
        ]);
    }
}