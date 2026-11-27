<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pre_registros', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('ci', 30);
            $table->string('telefono', 30)->nullable();
            $table->string('numero_placa', 30);
            $table->string('clase', 50);
            $table->string('marca', 80);
            $table->string('tipo_modelo', 80);
            $table->string('color', 40);
            $table->enum('estado', ['pendiente', 'aprobado', 'rechazado'])->default('pendiente');
            $table->text('observacion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pre_registros');
    }
};