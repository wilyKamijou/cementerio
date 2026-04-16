<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cementerio extends Model
{
    use HasFactory;
    protected $table = 'cementerios';
    protected $primaryKey = 'idCem';
    protected $fillable = [
        'nombre',
        'estado',
        'localizacion',
        'espacioDisp',

    ];

    // Relaciones
    public function espacios()
    {
        return $this->hasMany(Espacio::class, 'idCem', 'idCem');
    }
}
