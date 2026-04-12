<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $primaryKey = 'idEmpleado';
    protected $fillable = [
        'nombre',
        'paterno',
        'materno',
        'direccion',
        'telefono'
    ];

    // Relaciones
    public function usuario()
    {
        return $this->hasOne(User::class, 'idEmpleado', 'idEmpleado');
    }

    public function bitacora()
    {
        return $this->hasMany(Bitacora::class, 'idEmpleado', 'idEmpleado');
    }

    public function venta()
    {
        return $this->hasMany(venta::class, 'idEmpleado', 'idEmpleado');
    }
}
