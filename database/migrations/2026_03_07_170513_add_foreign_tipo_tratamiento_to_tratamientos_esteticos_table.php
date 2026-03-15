<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('tratamientos_esteticos', function (Blueprint $table) {
        if (!Schema::hasColumn('tratamientos_esteticos', 'tipo_tratamiento_id')) {
            $table->unsignedBigInteger('tipo_tratamiento_id')->nullable();
        }
        $table->foreign('tipo_tratamiento_id')
              ->references('id')->on('tipo_tratamientos')
              ->nullOnDelete();
    });
}

    public function down(): void
    {
        Schema::table('tratamientos_esteticos', function (Blueprint $table) {
            $table->dropForeign(['tipo_tratamiento_id']);
        });
    }
};
