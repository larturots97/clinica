<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tratamientos_esteticos', function (Blueprint $table) {
            $table->decimal('peso', 5, 1)->nullable()->after('objetivo');
            $table->decimal('talla', 5, 1)->nullable()->after('peso');
            $table->decimal('temperatura', 4, 1)->nullable()->after('talla');
            $table->string('tension_arterial', 20)->nullable()->after('temperatura');
            $table->unsignedSmallInteger('frecuencia_cardiaca')->nullable()->after('tension_arterial');
            $table->unsignedTinyInteger('saturacion_o2')->nullable()->after('frecuencia_cardiaca');
            $table->text('exploracion_fisica')->nullable()->after('saturacion_o2');
        });
    }

    public function down(): void
    {
        Schema::table('tratamientos_esteticos', function (Blueprint $table) {
            $table->dropColumn([
                'peso', 'talla', 'temperatura',
                'tension_arterial', 'frecuencia_cardiaca',
                'saturacion_o2', 'exploracion_fisica',
                'mapa_activo', 'zonas_texto',
            ]);
        });
    }
};