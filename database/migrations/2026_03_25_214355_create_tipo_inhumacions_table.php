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
       Schema::create('tipoInhumacion', function (Blueprint $table) {
        $table->id('idTipo');
        $table->string('nombre');
        $table->decimal('precio', 10, 2)->nullable();
        $table->decimal('precioBase', 10, 2)->nullable();
        $table->integer('capacidadMax')->nullable();
        $table->string('estado');
        $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipoInhumacion');
    }
};
