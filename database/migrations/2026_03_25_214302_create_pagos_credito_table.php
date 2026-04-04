<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
   Schema::create('pagosCredito', function (Blueprint $table) {
    $table->id('idPagoC');
    $table->foreignId('idVenta')->constrained('ventas','idVenta');  // ← HEREda la llave de venta
    $table->decimal('interes', 10, 2);
    $table->decimal('montoInicial', 10, 2);

    $table->foreignId('idComp')->constrained('compromisos','idComp');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagosCredito');
    }
};
