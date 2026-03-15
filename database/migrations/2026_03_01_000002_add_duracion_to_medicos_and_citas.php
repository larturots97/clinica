<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('medicos', function (Blueprint $table) {
            if (!Schema::hasColumn('medicos', 'duracion_cita'))
                $table->integer('duracion_cita')->default(30)->after('cedula');
        });
        Schema::table('citas', function (Blueprint $table) {
            if (!Schema::hasColumn('citas', 'duracion_minutos'))
                $table->integer('duracion_minutos')->default(30)->after('fecha_hora');
        });
    }
    public function down(): void {
        Schema::table('medicos', fn($t) => $t->dropColumn('duracion_cita'));
        Schema::table('citas',   fn($t) => $t->dropColumn('duracion_minutos'));
    }
};
