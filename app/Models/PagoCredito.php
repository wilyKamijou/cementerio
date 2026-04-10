<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoCredito extends Model
{
    use HasFactory;
    protected $primaryKey = 'idPagoC';
    protected $fillable = [
        'idVenta',
        'interes',
        'montoInicial'
    ];

    // Relaciones
    public function venta()
    {
        return $this->belongsTo(Venta::class, 'idVenta', 'idVenta');
    }
}
