<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->index('medico_id');
            $table->index('paciente_id');
            $table->index('fecha_hora');
            $table->index('estado');
        });

        Schema::table('tratamientos_esteticos', function (Blueprint $table) {
            $table->index('medico_id');
            $table->index('paciente_id');
            $table->index('fecha');
        });

        Schema::table('pacientes', function (Blueprint $table) {
            $table->index('clinica_id');
            $table->index('nombre');
        });

        Schema::table('historiales', function (Blueprint $table) {
            $table->index('medico_id');
            $table->index('paciente_id');
        });

        Schema::table('recetas', function (Blueprint $table) {
            $table->index('medico_id');
            $table->index('paciente_id');
        });
    }

    public function down(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->dropIndex(['medico_id']);
            $table->dropIndex(['paciente_id']);
            $table->dropIndex(['fecha_hora']);
            $table->dropIndex(['estado']);
        });

        Schema::table('tratamientos_esteticos', function (Blueprint $table) {
            $table->dropIndex(['medico_id']);
            $table->dropIndex(['paciente_id']);
            $table->dropIndex(['fecha']);
        });

        Schema::table('pacientes', function (Blueprint $table) {
            $table->dropIndex(['clinica_id']);
            $table->dropIndex(['nombre']);
        });

        Schema::table('historiales', function (Blueprint $table) {
            $table->dropIndex(['medico_id']);
            $table->dropIndex(['paciente_id']);
        });

        Schema::table('recetas', function (Blueprint $table) {
            $table->dropIndex(['medico_id']);
            $table->dropIndex(['paciente_id']);
        });
    }
};
