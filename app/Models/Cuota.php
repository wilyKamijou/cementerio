<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuota extends Model
{
    use HasFactory;

    protected $primaryKey = 'idCuota';
    protected $fillable = [
        'idPlanPago',
        'fechaVencimiento',
        'monto',
        'estado'
    ];

    // Relaciones
    public function planPago()
    {
        return $this->belongsTo(PlanPago::class, 'idPlanPago', 'idPlanPago');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'idCuota', 'idCuota');
    }
}