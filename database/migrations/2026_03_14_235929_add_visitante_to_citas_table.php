<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            // Solo agregar si no existen
            if (!Schema::hasColumn('citas', 'nombre_visitante')) {
                $table->string('nombre_visitante')->nullable()->after('origen');
            }
            if (!Schema::hasColumn('citas', 'telefono_visitante')) {
                $table->string('telefono_visitante')->nullable()->after('nombre_visitante');
            }
            if (!Schema::hasColumn('citas', 'email_visitante')) {
                $table->string('email_visitante')->nullable()->after('telefono_visitante');
            }
            if (!Schema::hasColumn('citas', 'motivo_visitante')) {
                $table->text('motivo_visitante')->nullable()->after('email_visitante');
            }
            if (!Schema::hasColumn('citas', 'hora_cita')) {
                $table->string('hora_cita', 5)->nullable()->after('motivo_visitante');
            }
            if (!Schema::hasColumn('citas', 'fecha_cita')) {
                $table->date('fecha_cita')->nullable()->after('hora_cita');
            }
        });
    }

    public function down(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->dropColumn(['nombre_visitante', 'telefono_visitante', 'email_visitante', 'motivo_visitante', 'hora_cita', 'fecha_cita']);
        });
    }
};