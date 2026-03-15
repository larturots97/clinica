<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configuraciones_medico', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medico_id');
            $table->unsignedBigInteger('clinica_id')->nullable();
            $table->string('logo')->nullable();
            $table->string('firma')->nullable();
            $table->string('clinica_nombre')->nullable();
            $table->string('clinica_direccion')->nullable();
            $table->string('clinica_ciudad')->nullable();
            $table->string('clinica_telefono')->nullable();
            $table->string('clinica_email')->nullable();
            $table->text('consentimiento_punto_1')->nullable();
            $table->text('consentimiento_punto_2')->nullable();
            $table->text('consentimiento_punto_3')->nullable();
            $table->text('consentimiento_punto_4')->nullable();
            $table->text('consentimiento_punto_5')->nullable();
            $table->text('consentimiento_punto_6')->nullable();
            $table->text('consentimiento_punto_7')->nullable();
            $table->text('consentimiento_punto_8')->nullable();
            $table->text('consentimiento_punto_9')->nullable();
            $table->text('consentimiento_punto_10')->nullable();
            $table->text('consentimiento_punto_11')->nullable();
            $table->text('consentimiento_punto_12')->nullable();
            $table->timestamps();

            $table->foreign('medico_id')->references('id')->on('medicos')->onDelete('cascade');
            $table->foreign('clinica_id')->references('id')->on('clinicas')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configuraciones_medico');
    }
};