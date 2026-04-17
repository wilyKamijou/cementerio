
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUniqueConstraintsFromInhumaciones extends Migration
{
    public function up()
    {
        Schema::table('inhumaciones', function (Blueprint $table) {
            // Eliminar las restricciones UNIQUE
            $table->dropUnique('inhumaciones_idespacio_unique');
            $table->dropUnique('inhumaciones_idtipo_unique');
        });
    }

    public function down()
    {
        Schema::table('inhumaciones', function (Blueprint $table) {
            // Revertir (volver a poner UNIQUE)
            $table->unique('idEspacio');
            $table->unique('idTipo');
        });
    }
}
