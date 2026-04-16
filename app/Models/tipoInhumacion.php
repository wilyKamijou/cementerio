<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoInhumacion extends Model
{
    use HasFactory;
    protected $table = 'tipoInhumacion';
    protected $primaryKey = 'idTipo';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nombre',
        'precio',
        'capacidadMax',
        'estado',
        'areaBase'
    ];

    // Relaciones
    public function inhumaciones()
    {
        return $this->hasMany(Inhumacion::class, 'idTipo', 'idTipo');
    }
}
