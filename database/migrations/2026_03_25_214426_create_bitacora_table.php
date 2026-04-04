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
       Schema::create('bitacora', function (Blueprint $table) {
        $table->id('idBitacora');
        $table->date('fecha');
        $table->time('hora');
        $table->string('tabla');
        $table->integer('nroRegistro');
        $table->string('transaccion');

        $table->foreignId('idEmpleado')->constrained('empleados','idEmpleado');
        $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitacora');
    }
};
