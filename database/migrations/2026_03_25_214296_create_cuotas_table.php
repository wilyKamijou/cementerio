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
    Schema::create('cuotas', function (Blueprint $table) {
        $table->id('idCuota');  // ← Sola, no compuesta
        $table->foreignId('idPlanPago')->constrained('planesPago','idPlanPago');
        $table->date('fechaVencimiento');
        $table->decimal('monto', 10, 2);
        $table->string('estado');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuotas');
    }
};
