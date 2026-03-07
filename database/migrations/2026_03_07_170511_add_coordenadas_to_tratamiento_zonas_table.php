<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tratamiento_zonas', function (Blueprint $table) {
            $table->string('tipo', 20)->default('predefinida')->after('zona'); // predefinida | libre
            $table->decimal('coord_x', 6, 2)->nullable()->after('tipo');
            $table->decimal('coord_y', 6, 2)->nullable()->after('coord_x');
            $table->string('color', 10)->nullable()->after('coord_y');
            $table->boolean('activa')->default(true)->after('color');
        });
    }

    public function down(): void
    {
        Schema::table('tratamiento_zonas', function (Blueprint $table) {
            $table->dropColumn(['tipo','coord_x','coord_y','color','activa']);
        });
    }
};
