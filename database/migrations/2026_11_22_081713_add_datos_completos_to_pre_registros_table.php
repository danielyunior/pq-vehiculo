<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pre_registros', function (Blueprint $table) {
            if (!Schema::hasColumn('pre_registros', 'domicilio')) {
                $table->string('domicilio')->nullable()->after('ci');
            }
            if (!Schema::hasColumn('pre_registros', 'ocupacion')) {
                $table->string('ocupacion', 100)->nullable()->after('domicilio');
            }
            if (!Schema::hasColumn('pre_registros', 'lugar_trabajo')) {
                $table->string('lugar_trabajo', 150)->nullable()->after('ocupacion');
            }
            if (!Schema::hasColumn('pre_registros', 'tipo_documento')) {
                $table->string('tipo_documento', 50)->nullable()->after('telefono');
            }
            if (!Schema::hasColumn('pre_registros', 'numero_chasis')) {
                $table->string('numero_chasis', 100)->nullable()->after('color');
            }
            if (!Schema::hasColumn('pre_registros', 'numero_motor')) {
                $table->string('numero_motor', 100)->nullable()->after('numero_chasis');
            }
            if (!Schema::hasColumn('pre_registros', 'cilindrada')) {
                $table->string('cilindrada', 50)->nullable()->after('numero_motor');
            }
            if (!Schema::hasColumn('pre_registros', 'tipo_combustible')) {
                $table->string('tipo_combustible', 50)->nullable()->after('cilindrada');
            }
            if (!Schema::hasColumn('pre_registros', 'numero_puertas')) {
                $table->unsignedInteger('numero_puertas')->nullable()->after('tipo_combustible');
            }
            if (!Schema::hasColumn('pre_registros', 'anio')) {
                $table->unsignedSmallInteger('anio')->nullable()->after('tipo_modelo');
            }
            if (!Schema::hasColumn('pre_registros', 'capacidad')) {
                $table->string('capacidad', 50)->nullable()->after('anio');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pre_registros', function (Blueprint $table) {
            $columnas = [
                'domicilio',
                'ocupacion',
                'lugar_trabajo',
                'tipo_documento',
                'numero_chasis',
                'numero_motor',
                'cilindrada',
                'tipo_combustible',
                'numero_puertas',
                'anio',
                'capacidad',
            ];

            foreach ($columnas as $col) {
                if (Schema::hasColumn('pre_registros', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};