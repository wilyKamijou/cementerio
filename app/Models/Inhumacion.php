<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inhumacion extends Model
{
    use HasFactory;

    protected $primaryKey = 'idInhum';
    protected $fillable = [
        'nombre',
        'paterno',
        'materno',
        'fechaNaci',
        'fechaDefun',
        'fechaInhuma',
        'causaMuer',
        'idEspacio',
        'idTipo'
    ];

    // Relaciones
    public function tipoInhumacion()
    {
        return $this->belongsTo(TipoInhumacion::class, 'idTipo', 'idTipo');
    }

    public function espacio()
    {
        return $this->belongsTo(Espacio::class, 'idEspacio', 'idEspacio');
    }
}