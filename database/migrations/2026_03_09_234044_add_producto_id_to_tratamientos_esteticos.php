<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tratamientos_esteticos', function (Blueprint $table) {
            $table->foreignId('producto_id')->nullable()->after('producto_marca')->constrained('productos')->nullOnDelete();
            $table->decimal('producto_cantidad', 8, 2)->nullable()->after('producto_id');
        });
    }

    public function down(): void
    {
        Schema::table('tratamientos_esteticos', function (Blueprint $table) {
            $table->dropForeign(['producto_id']);
            $table->dropColumn(['producto_id', 'producto_cantidad']);
        });
    }
};
