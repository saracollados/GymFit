<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {
        $this->call(GenerosTablaMaestraSeeder::class);
        $this->call(RolesPersonalTablaMaestraSeeder::class);
        $this->call(DiasSemanaTablaMaestraSeeder::class);
        $this->call(FranjasHorariasTablaMaestraSeeder::class);
        $this->call(UsuariosSeeder::class);
        $this->call(PersonalSeeder::class);
        $this->call(SalasSeeder::class);
        $this->call(ClasesSeeder::class);
        $this->call(HorariosSeeder::class);
        $this->call(HorariosClasesSeeder::class);
        $this->call(ClasesHistoricoSeeder::class);
        $this->call(ReservasSeeder::class);
        $this->call(HorarioServiciosSeeder::class);
        $this->call(ReservasServiciosSeeder::class);
    }
}
