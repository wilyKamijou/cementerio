<?php
// database/migrations/2025_01_01_000016_create_pagos_contado_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagosContado', function (Blueprint $table) {
            $table->id('idPagoCn');
            $table->foreignId('idVenta')->constrained('ventas','idVenta');
            $table->decimal('descuento', 10, 2)->default(0);
            $table->string('metodoPago');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagosContado');
    }
};