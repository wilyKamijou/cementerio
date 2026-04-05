<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasFactory;

    protected $primaryKey = 'idCont';
    protected $fillable = [
        'fechaContrato',
        'montoBase',
        'saldoPendiente',
        'estado',
        'observacion',
        'idVenta',
        'idCliente'
    ];

    // Relaciones
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'idCliente', 'idCliente');
    }

    public function venta()
    {
        return $this->hasOne(Venta::class, 'idVenta', 'idVenta');
    }
    
    public function espacio()
    {
        return $this->hasMany(Espacio::class,'idCont','idCont');
    }
}