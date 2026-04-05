<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = [
        'precioU',
        'cantidad',
        'idVenta',
        'idEspacio'
    ];

    // Relaciones
    public function venta()
    {
        return $this->belongsTo(Venta::class, 'idVenta', 'idVenta');
    }

    public function espacio()
    {
        return $this->belongsTo(Espacio::class, 'idEspacio', 'idEspacio');
    }
}