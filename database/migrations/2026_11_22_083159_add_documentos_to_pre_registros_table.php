<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pre_registros', function (Blueprint $table) {
            if (!Schema::hasColumn('pre_registros', 'doc_ci')) {
                $table->string('doc_ci')->nullable()->after('observacion');
            }
            if (!Schema::hasColumn('pre_registros', 'doc_propiedad')) {
                $table->string('doc_propiedad')->nullable()->after('doc_ci');
            }
            if (!Schema::hasColumn('pre_registros', 'doc_diprove')) {
                $table->string('doc_diprove')->nullable()->after('doc_propiedad');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pre_registros', function (Blueprint $table) {
            foreach (['doc_ci', 'doc_propiedad', 'doc_diprove'] as $col) {
                if (Schema::hasColumn('pre_registros', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};