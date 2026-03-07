<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('medicos', function (Blueprint $table) {
            $table->string('logo')->nullable()->after('activo');
            $table->string('firma')->nullable()->after('logo');
            $table->string('cedula')->nullable()->after('firma');
        });
    }

    public function down(): void
    {
        Schema::table('medicos', function (Blueprint $table) {
            $table->dropColumn(['logo', 'firma', 'cedula']);
        });
    }
};
