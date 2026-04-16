<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Espacio extends Model
{
    use HasFactory;
    protected $table = 'espacios';
    protected $primaryKey = 'idEspacio';
    protected $fillable = [
        'idCem',
        'idDim',
        'idDir',
        'precio',
        'estado'

    ];

    // Relaciones
    public function cementerio()
    {
        return $this->belongsTo(Cementerio::class, 'idCem', 'idCem');
    }

    public function dimension()
    {
        return $this->belongsTo(Dimension::class, 'idDim', 'idDim');
    }

    public function direccion()
    {
        return $this->belongsTo(Direccion::class, 'idDir', 'idDir');
    }

    public function inhumaciones()
    {
        return $this->hasMany(Inhumacion::class, 'idEspacio', 'idEspacio');
    }

    public function mantenimientos()
    {
        return $this->hasMany(Mantenimiento::class, 'idEspacio', 'idEspacio');
    }

    public function detalleVentas()
    {
        return $this->hasOne(DetalleVenta::class, 'idEspacio', 'idEspacio');
    }
}
