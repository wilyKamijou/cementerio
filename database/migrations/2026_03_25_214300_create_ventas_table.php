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
    Schema::create('ventas', function (Blueprint $table) {
        $table->id('idVenta');  // Llave primaria
        $table->date('fechaVenta');
        $table->decimal('precioTotal', 12, 2);
        $table->string('estado');

        $table->foreignId('idEmpleado')->constrained('empleados','idEmpleado');
        $table->foreignId('idCliente')->constrained('clientes','idCliente');
        $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
