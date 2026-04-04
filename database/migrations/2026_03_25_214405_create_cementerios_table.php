<?php
// database/migrations/xxxx_xx_xx_000001_create_cementerios_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cementerios', function (Blueprint $table) {
            $table->id('idCem');
            $table->string('nombre');
            $table->string('estado');
            $table->string('localizacion')->nullable();
            $table->string('espacioDisp')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cementerios');
    }
};