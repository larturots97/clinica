<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up(): void
    {
        Schema::table('configuraciones_medico', function (Blueprint $table) {
            $table->string('receta_direccion', 255)->nullable()->after('clinica_email');
            $table->string('receta_instagram', 100)->nullable()->after('receta_direccion');
            $table->string('receta_facebook', 100)->nullable()->after('receta_instagram');
            $table->string('receta_whatsapp', 30)->nullable()->after('receta_facebook');
            $table->string('receta_logo_fondo')->nullable()->after('receta_whatsapp');
        });
    }

    public function down(): void
    {
        Schema::table('configuraciones_medico', function (Blueprint $table) {
            $table->dropColumn(['receta_direccion','receta_instagram','receta_facebook','receta_whatsapp','receta_logo_fondo']);
        });
    }
};
