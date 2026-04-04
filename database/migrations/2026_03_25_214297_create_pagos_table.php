<?php
// database/migrations/xxxx_xx_xx_000016_create_pagos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id('idPago'); // IdPago
            $table->foreignId('idCuota')->constrained('cuotas','idCuota');
            $table->date('fechaPago');
            $table->decimal('montoPagado', 10, 2);
            $table->decimal('montoInteres', 10, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};