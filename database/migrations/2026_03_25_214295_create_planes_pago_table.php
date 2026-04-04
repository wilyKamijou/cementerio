<?php
// database/migrations/xxxx_xx_xx_000011_create_planes_pago_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('planesPago', function (Blueprint $table) {
            $table->id('idPlanPago'); // IdPlanPago
            $table->date('fechaInicio');
            $table->date('fechaFin');
            $table->string('frecuencia');
            $table->decimal('monto', 10, 2);
            $table->decimal('interesAnual', 5, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('planesPago');
    }
};