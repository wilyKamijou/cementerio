<?php
// database/migrations/xxxx_xx_xx_000005_create_espacios_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
   Schema::create('espacios', function (Blueprint $table) {
        $table->id('idEspacio');
        $table->decimal('precio', 10, 2);
        $table->string('estado'); 

        $table->foreignId('idDir')->constrained('direcciones','idDir');
        $table->foreignId('idDim')->constrained('dimensiones','idDim');
        $table->foreignId('idCem')->constrained('cementerios','idCem');
        $table->foreignId('idCont')->constrained('contratos','idCont');
        $table->timestamps();
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('espacios');
    }
};