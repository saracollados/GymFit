<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('personal', function (Blueprint $table) {
            $table->id();
            $table->string('dni', 9)->unique();
            $table->string('nombre');
            $table->unsignedInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles_personal_tabla_maestra');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('personal');
    }
};
