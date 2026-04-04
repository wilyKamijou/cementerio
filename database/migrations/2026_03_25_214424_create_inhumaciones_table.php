<?php
// database/migrations/2025_01_01_000019_create_inhumaciones_table.php

use App\Models\tipoInhumacion;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inhumaciones', function (Blueprint $table) {
            $table->id('idInhum'); // IdInhumacion
            $table->string('nombre');
            $table->string('paterno'); // paterno
            $table->string('materno')->nullable(); // materno
            $table->date('fechaNaci')->nullable(); // fechaNaci
            $table->date('fechaDefun'); // fechaDefun
            $table->date('fechaInhuma'); // fechainhuma
            $table->string('causaMuer')->nullable(); // causaMuer
            
            $table->foreignId('idEspacio')->unique()->constrained('espacios','idEspacio');
            $table->foreignId('idTipo')->unique()->constrained('tipoInhumacion','idTipo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inhumaciones');
    }
};