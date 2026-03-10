<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tratamientos_esteticos', function (Blueprint $table) {
            $table->boolean('mapa_activo')->default(true)->after('saturacion_o2');
            $table->text('zonas_texto')->nullable()->after('mapa_activo');
        });
    }

    public function down(): void
    {
        Schema::table('tratamientos_esteticos', function (Blueprint $table) {
            $table->dropColumn(['mapa_activo', 'zonas_texto']);
        });
    }
};
