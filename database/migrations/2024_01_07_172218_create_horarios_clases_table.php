<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('horarios_clases', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('horario_id');
            $table->foreign('horario_id')->references('id')->on('horarios');
            $table->unsignedInteger('dia_semana_id');
            $table->foreign('dia_semana_id')->references('id')->on('dias_semana_tabla_maestra');
            $table->unsignedInteger('franja_horaria_id');
            $table->foreign('franja_horaria_id')->references('id')->on('franjas_horarias_tabla_maestra');
            $table->unsignedInteger('clase_id');
            $table->foreign('clase_id')->references('id')->on('clases');
            $table->unsignedInteger('monitor_id');
            $table->foreign('monitor_id')->references('id')->on('personal');
            $table->unsignedInteger('sala_id');
            $table->foreign('sala_id')->references('id')->on('salas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('horarios_clases');
    }
};
