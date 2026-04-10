<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoContado extends Model
{
    use HasFactory;
    protected $primaryKey = 'idPagoCn';
    protected $fillable = [
        'idVenta',
        'descuento',
        'metodoPago'
    ];

    // Relaciones
    public function venta()
    {
        return $this->belongsTo(Venta::class, 'idCont', 'idCont');
    }
}
