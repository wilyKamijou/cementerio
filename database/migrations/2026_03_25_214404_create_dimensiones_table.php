<?php
// database/migrations/xxxx_xx_xx_000007_create_dimensiones_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dimensiones', function (Blueprint $table) {
            $table->id('idDim'); // IdDimension
            $table->decimal('ancho', 8, 2);
            $table->decimal('largo', 8, 2);
            $table->decimal('area', 10, 2)->storedAs('ancho * largo'); // área calcula
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dimensiones');
    }
};