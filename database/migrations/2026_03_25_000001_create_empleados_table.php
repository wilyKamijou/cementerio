<?php
// database/migrations/xxxx_xx_xx_000004_create_agentes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id('idEmpleado'); // IdAgente
            $table->string('nombre');
            $table->string('paterno');
            $table->string('materno')->nullable();  
            $table->text('direccion')->nullable();      
            $table->string('telefono');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};