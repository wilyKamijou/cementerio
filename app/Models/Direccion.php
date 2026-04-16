<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    use HasFactory;
    protected $table = 'direcciones';
    protected $primaryKey = 'idDir';
    protected $fillable = [
        'seccion',
        'numero',
        'calle',
        'fila'
    ];

    // Relaciones
    public function espacios()
    {
        return $this->hasOne(Espacio::class, 'idDir', 'idDir');
    }
}
