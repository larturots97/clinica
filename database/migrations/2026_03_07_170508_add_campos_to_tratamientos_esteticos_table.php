<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tratamientos_esteticos', function (Blueprint $table) {
            $table->string('grupo', 1)->nullable()->after('tipo_tratamiento_id');
            $table->string('tipo_clave', 30)->nullable()->after('grupo');
            $table->string('motivo_consulta')->nullable()->after('tipo_clave');
            $table->tinyInteger('fitzpatrick')->nullable()->after('motivo_consulta');
            $table->json('tipo_piel')->nullable()->after('fitzpatrick');
            $table->json('condiciones_piel')->nullable()->after('tipo_piel');
            $table->json('antecedentes')->nullable()->after('condiciones_piel');
            $table->string('simetria')->nullable()->after('antecedentes');
            $table->string('tonicidad')->nullable()->after('simetria');
            $table->string('tecnica')->nullable()->after('tonicidad');
            $table->string('profundidad')->nullable()->after('tecnica');
            $table->string('producto_marca')->nullable()->after('profundidad');
            $table->string('producto_lote')->nullable()->after('producto_marca');
            $table->date('producto_caducidad')->nullable()->after('producto_lote');
            $table->integer('sesion_numero')->default(1)->after('producto_caducidad');
            $table->string('intervalo')->nullable()->after('sesion_numero');
            $table->decimal('volumen_total', 6, 2)->nullable()->after('intervalo');
            $table->string('unidad_volumen', 10)->nullable()->after('volumen_total');
            $table->text('objetivo')->nullable()->after('unidad_volumen');
            $table->text('observaciones_post')->nullable()->after('objetivo');
            $table->string('consentimiento_idioma', 10)->default('es')->after('observaciones_post');
            $table->string('consentimiento_entrega', 20)->nullable()->after('consentimiento_idioma');
            $table->json('campos_extra')->nullable()->after('consentimiento_entrega');
        });
    }

    public function down(): void
    {
        Schema::table('tratamientos_esteticos', function (Blueprint $table) {
            $table->dropColumn([
                'grupo','tipo_clave','motivo_consulta',
                'fitzpatrick','tipo_piel','condiciones_piel','antecedentes',
                'simetria','tonicidad','tecnica','profundidad',
                'producto_marca','producto_lote','producto_caducidad',
                'sesion_numero','intervalo','volumen_total','unidad_volumen',
                'objetivo','observaciones_post',
                'consentimiento_idioma','consentimiento_entrega','campos_extra',
            ]);
        });
    }
};
