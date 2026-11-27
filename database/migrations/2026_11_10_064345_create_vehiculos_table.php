<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            
            // Datos del Propietario
            $table->string('nombre');
            $table->string('apellido');
            $table->string('ci');
            $table->string('domicilio');
            $table->string('ocupacion');
            $table->string('lugar_trabajo');
            
            // Datos Técnicos del Vehículo
            $table->string('marca');
            $table->string('clase');
            $table->string('color');
            $table->string('numero_chasis')->unique();
            $table->string('numero_motor')->unique();
            $table->string('cilindrada');
            $table->string('tipo_combustible');
            $table->integer('numero_puertas');
            $table->string('tipo_modelo');
            $table->integer('anio');
            $table->string('capacidad');
            $table->string('numero_placa')->unique();
            $table->string('tipo_documento');

            // Control y Sistema
            $table->string('codigo_qr')->unique();
            $table->enum('estado', ['ACTIVO', 'INACTIVO'])->default('ACTIVO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};