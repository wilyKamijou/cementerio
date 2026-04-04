<?php
// database/migrations/2025_01_01_000010_create_contratos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contratos', function (Blueprint $table) {
            $table->id('idCont'); // IdContrato
            $table->date('fechaContrato');
            $table->decimal('montoBase', 10, 2);
            $table->decimal('saldoPendiente', 10, 2);
            $table->string('estado');
            $table->text('observacion')->nullable();

            $table->foreignId('idVenta')->unique()->constrained('ventas','idVenta');
            $table->foreignId('idCliente')->unique()->constrained('clientes','idCliente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contratos');
    }
};