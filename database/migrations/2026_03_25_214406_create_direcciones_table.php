<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('direcciones', function (Blueprint $table) {
            $table->id('idDir'); 
            $table->string('seccion');
            $table->string('numero');
            $table->string('calle');
            $table->string('fila');
            
            $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('direcciones');
    }
};
