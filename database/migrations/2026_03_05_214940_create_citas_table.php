<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinica_id')->constrained()->cascadeOnDelete();
            $table->foreignId('paciente_id')->constrained()->cascadeOnDelete();
            $table->foreignId('medico_id')->constrained()->cascadeOnDelete();
            $table->dateTime('fecha_hora');
            $table->integer('duracion_minutos')->default(30);
            $table->string('motivo')->nullable();
            $table->enum('estado', [
                'pendiente',
                'confirmada',
                'en_curso',
                'completada',
                'cancelada'
            ])->default('pendiente');
            $table->text('notas')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};