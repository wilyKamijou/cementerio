<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    use HasFactory;

    protected $primaryKey = 'idMant';
    protected $fillable = [
        'idEspacio',
        'precio',
        'fechaMant',
        'descripcion',
        'estado',
        'tipo'
    ];

    // Relaciones
    public function espacio()
    {
        return $this->belongsTo(Espacio::class, 'idEspacio', 'idEspacio');
    }
}
