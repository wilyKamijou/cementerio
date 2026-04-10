<?php
// database/migrations/xxxx_xx_xx_000006_create_rol_permiso_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rolPermiso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idRol')->constrained('roles', 'idRol')->onDelete('cascade');
            $table->foreignId('idPer')->constrained('permisos', 'idPer')->onDelete('cascade');

            $table->unique(['idRol', 'idPer']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rolPermiso');
    }
};
