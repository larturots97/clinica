<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tratamientos_esteticos', function (Blueprint $table) {
            $table->text('firma_paciente')->nullable()->after('consentimiento_entrega');
            $table->timestamp('firma_paciente_at')->nullable()->after('firma_paciente');
        });
    }

    public function down(): void
    {
        Schema::table('tratamientos_esteticos', function (Blueprint $table) {
            $table->dropColumn(['firma_paciente', 'firma_paciente_at']);
        });
    }
};