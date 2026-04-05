<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanPago extends Model
{
    use HasFactory;

    protected $primaryKey = 'idPlanPago';
    protected $fillable = [
        'fechaInicio',
        'fechaFin',
        'frecuencia',
        'monto',
        'interesAnual'
    ];

    // Relaciones
    public function compromisos()
    {
        return $this->hasMany(Compromiso::class, 'idPlanPago', 'idPlanPago');
    }

    public function cuotas()
    {
        return $this->hasMany(Cuota::class, 'idPlanPago', 'idPlanPago');
    }
}