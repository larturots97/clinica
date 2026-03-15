<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('landing_medico', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medico_id')->constrained('medicos')->onDelete('cascade');

            // Hero
            $table->string('foto_doctora')->nullable();
            $table->string('hero_titulo')->default('Realza tu belleza natural.');
            $table->string('hero_subtitulo')->nullable();
            $table->text('hero_descripcion')->nullable();

            // Sobre mí
            $table->string('foto_consultorio')->nullable();
            $table->text('sobre_mi')->nullable();
            $table->string('anos_experiencia')->nullable();
            $table->string('num_pacientes')->nullable();

            // Contacto / horario
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('horario')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();

            // Configuración general
            $table->boolean('activa')->default(true);
            $table->timestamps();
        });

        // Tabla de servicios de la landing
        Schema::create('landing_servicios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medico_id')->constrained('medicos')->onDelete('cascade');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('icono')->nullable();
            $table->integer('orden')->default(0);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Tabla de galería de la landing
        Schema::create('landing_galeria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medico_id')->constrained('medicos')->onDelete('cascade');
            $table->string('imagen');
            $table->string('titulo')->nullable();
            $table->integer('orden')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('landing_galeria');
        Schema::dropIfExists('landing_servicios');
        Schema::dropIfExists('landing_medico');
    }
};