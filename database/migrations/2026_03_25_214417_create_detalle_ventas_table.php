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
        Schema::create('detalleVentas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idVenta')->unique()->constrained('ventas','idVenta');
            $table->foreignId('idEspacio')->unique()->constrained('espacios','idEspacio');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalleVentas');
    }
};
