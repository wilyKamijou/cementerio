<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    use HasFactory;

    protected $primaryKey = 'idBitacora';
    protected $fillable = [
        'fecha',
        'hora',
        'tabla',
        'nroRegistro',
        'transaccion',
        'idEmpleado'
    ];

    public function empledos()
    {
        return $this->belongsTo(empleado::class,'idEmpleado','idEmpleado');
    }
}