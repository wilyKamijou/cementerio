<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected   $table = 'clientes';
    protected $primaryKey = 'idCliente';
    protected $fillable = [
        'Ci',
        'nombre',
        'paterno',
        'telefono',
        'direccion'
    ];

    // Relaciones
    public function contratos()
    {
        return $this->hasMany(Contrato::class, 'idCliente', 'idCliente');
    }

    public function usuario()
    {
        return $this->hasOne(User::class, 'idCliente', 'idCliente');
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'idCliente', 'idCliente');
    }
}
