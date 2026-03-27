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
    Schema::table('pacientes', function (Blueprint $table) {
        $table->string('tipo_sangre', 5)->nullable()->after('genero');
    });
}

public function down(): void
{
    Schema::table('pacientes', function (Blueprint $table) {
        $table->dropColumn('tipo_sangre');
    });
}
};
