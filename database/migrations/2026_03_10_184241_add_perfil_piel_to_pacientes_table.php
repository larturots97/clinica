<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pacientes', function (Blueprint $table) {
            $table->integer('fitzpatrick')->nullable()->after('antecedentes');
            $table->json('tipo_piel')->nullable()->after('fitzpatrick');
            $table->json('condiciones_piel')->nullable()->after('tipo_piel');
            $table->text('nota_medica')->nullable()->after('condiciones_piel');
        });
    }

    public function down(): void
    {
        Schema::table('pacientes', function (Blueprint $table) {
            $table->dropColumn(['fitzpatrick', 'tipo_piel', 'condiciones_piel', 'nota_medica']);
        });
    }
};