<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $primaryKey = 'idVenta';
    protected $fillable = [
        'fechaVenta',
        'precioTotal',
        'idEmpleado',
        'idCliente',
        'idCont'

    ];

    // Relaciones
    public function contrato()
    {
        return $this->belongsTo(Contrato::class, 'idCont', 'idCont');
    }

    public function detalleVentas()
    {
        return $this->hasMany(DetalleVenta::class, 'idVenta', 'idVenta');
    }

    public function pagoCredito()
    {
        return $this->hasOne(PagoCredito::class, 'idVenta', 'idVenta');
    }

    public function pagoContado()
    {
        return $this->hasOne(PagoContado::class, 'idVenta', 'idVenta');
    }

    public function cliente()
    {
        return $this->belongsTo(cliente::class, 'idCliente', 'idCliente');
    }

    public function empleado()
    {
        return $this->belongsTo(empleado::class, 'idEmpleado', 'idEmpleado');
    }
}
