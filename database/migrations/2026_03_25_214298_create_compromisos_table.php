<?php
// database/migrations/2025_01_01_000011_create_compromisos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compromisos', function (Blueprint $table) {
            $table->id('idComp'); // IdCompromiso
            $table->foreignId('idPlanPago')->constrained('planesPago','idPlanPago');
            $table->date('fechaCompromiso');
            $table->integer('plazo'); // días
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compromisos');
    }
};