<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClasesSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::table('clases')->insert([
            ['id' => '1', 'nombre' => 'Spinning', 'color' => '#ffc0cb', 'descripcion' => 'Disfruta del entrenamiento cardiovascular en grupo, sin dificultad coreográfica, y al ritmo de la música. 1 hora intensa en al cual quemarás calorías y mejorarás tu capacidad aeróbica.'],
            ['id' => '2', 'nombre' => 'Zumba', 'color' => '#87ceeb', 'descripcion' => 'Entrenamiento y diversión en una sesión de 1 hora donde disfrutarás de tu música latina favorita. Aprende a bailar diferentes ritmos latinos como salsa, bachata, merengue... mientras haces trabajo cardiovascular intenso, con coreografías sencillas que te permitirán seguir la sesión correctamente y disfrutar de todos sus beneficios.'],
            ['id' => '3', 'nombre' => 'BodyCombat', 'color' => '#98fb98', 'descripcion' => 'Sesión cardiovascular intensa basada en técnicas de combate. Una gran descarga de adrenalina con el máximo rendimiento.'],
            ['id' => '4', 'nombre' => 'BodyStep', 'color' => '#ffeb3b', 'descripcion' => 'Coreografías con un escalón al ritmo de la música. Ideal para entrenar la musculatura de piernas y glúteos. Entrenamiento cardiovascular.'],
            ['id' => '5', 'nombre' => 'BodyPump', 'color' => '#e6e6fa', 'descripcion' => 'Entrena en grupo los principales grupos musculares al ritmo de la música. Una actividad apta para cualquier persona y una de las mejores maneras de fortalezer y tonificar tu cuerpo.'],
            ['id' => '6', 'nombre' => 'Pilates', 'color' => '#7fffd4', 'descripcion' => 'Fortalece el equilibro muscular mediante un sistema de ejercicios centrado en la postura, la respiración y desarrollo de la fuerza y de la flexibilidad. El ritmo pausado del trabajo aporta calma y tranquilidad.'],
            ['id' => '7', 'nombre' => 'Ent. Funcional', 'color' => '#ffdab9', 'descripcion' => 'Esta actividad permite, a través de cargas libres, el entrenamiento de la fuerza que combina sobrecarga con alta intensidad, provocando múltiples e importantes mejoras en al funcionalidad de nuestro cuerpo.'],
            ['id' => '8', 'nombre' => 'Yoga', 'color' => '#add8e6', 'descripcion' => 'Yoga significa "unión". Esta unión se refiere a la "unión con uno mismo", la fusión harmónica de cuerpo, mente y espíritu: y por otro lado a la unión del individuo con el Cosmos.'],
            ['id' => '9', 'nombre' => 'GAP', 'color' => '#d3a5a5', 'descripcion' => 'Una combinación variada de ejercicios de fuerza y resistencia muscular con la que trabajarán intensamente tus glúteos, abdominales y piernas.'],
        ]);
    }
}
