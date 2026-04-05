<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $primaryKey = 'idPago';
    protected $fillable = [
        'idCuota',
        'fechaPago',
        'montoPagado',
        'montoInteres'
    ];

    // Relaciones
    public function cuota()
    {
        return $this->belongsTo(Cuota::class, 'idCuota', 'idCuota');
    }
}