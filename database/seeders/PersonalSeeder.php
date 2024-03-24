<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PersonalSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::statement('ALTER TABLE personal AUTO_INCREMENT = 1');
        DB::table('personal')->insert([
            ['dni' => '78563412A', 'nombre' => 'Juan López', 'role_id' => '2', 'email' => 'jlopez@gmail.com', 'password' => Hash::make('1234')],
            ['dni' => '89021543B', 'nombre' => 'Alba Martínez', 'role_id' => '3', 'email' => 'amartinez@gmail.com', 'password' => Hash::make('1234')],
            ['dni' => '45678903C', 'nombre' => 'Raúl Fernández', 'role_id' => '2', 'email' => 'rfernandez@gmail.com', 'password' => Hash::make('1234')],
            ['dni' => '21083467D', 'nombre' => 'Mateo Castro', 'role_id' => '1', 'email' => 'mcastro@gmail.com', 'password' => Hash::make('1234')],
            ['dni' => '69857321E', 'nombre' => 'Sofía Sánchez ', 'role_id' => '4', 'email' => 'ssanchez@gmail.com', 'password' => Hash::make('1234')],
            ['dni' => '54327689F', 'nombre' => 'Alejandro Castro', 'role_id' => '2', 'email' => 'acastro@gmail.com', 'password' => Hash::make('1234')],
            ['dni' => '16789230G', 'nombre' => 'Santiago Gómez', 'role_id' => '2', 'email' => 'sgomez@gmail.com', 'password' => Hash::make('1234')],
            ['dni' => '34529876H', 'nombre' => 'Valentina Rubio', 'role_id' => '2', 'email' => 'vrubio@gmail.com', 'password' => Hash::make('1234')],
            ['dni' => '91053246I', 'nombre' => 'Adriana Sánchez', 'role_id' => '4', 'email' => 'asanchez@gmail.com', 'password' => Hash::make('1234')],
            ['dni' => '23487659J', 'nombre' => 'Aitana Castro', 'role_id' => '3', 'email' => 'aicastro@gmail.com', 'password' => Hash::make('1234')],
            ['dni' => '78901254K', 'nombre' => 'Alejandro Serrano', 'role_id' => '2', 'email' => 'aserrano@gmail.com', 'password' => Hash::make('1234')],
            ['dni' => '56789021L', 'nombre' => 'Antonio Sánchez', 'role_id' => '1', 'email' => 'ansanchez@gmail.com', 'password' => Hash::make('1234')]
        ]);
    }
}
