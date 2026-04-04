<?php
// database/migrations/xxxx_xx_xx_000003_create_clientes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id('idCliente'); // IdCliente
            $table->integer('Ci')->unique();
            $table->string('nombre');
            $table->string('paterno');
            $table->string('telefono');
            $table->text('direccion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};