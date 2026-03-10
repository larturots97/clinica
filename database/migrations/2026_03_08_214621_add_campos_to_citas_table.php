<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->foreignId('tipo_tratamiento_id')->nullable()->constrained('tipo_tratamientos')->nullOnDelete()->after('medico_id');
            $table->string('telefono_paciente', 20)->nullable()->after('notas');
            $table->string('email_paciente', 100)->nullable()->after('telefono_paciente');
            $table->boolean('recordatorio_enviado')->default(false)->after('email_paciente');
        });
    }

    public function down(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->dropForeign(['tipo_tratamiento_id']);
            $table->dropColumn(['tipo_tratamiento_id', 'telefono_paciente', 'email_paciente', 'recordatorio_enviado']);
        });
    }
};
