<?php
// database/migrations/2025_01_01_000020_create_mantenimientos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->id('idMant'); // IdMantenimiento
            $table->foreignId('idEspacio')->constrained('espacios', 'idEspacio');
            $table->decimal('precio', 10, 2);
            $table->date('fechaMant');
            $table->text('descripcion')->nullable();
            $table->string('estado');
            $table->string('tipo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mantenimientos');
    }
};
