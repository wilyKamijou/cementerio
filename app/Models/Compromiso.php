<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compromiso extends Model
{
    use HasFactory;

    protected $primaryKey = 'idComp';
    protected $fillable = [
        'idPlanPAago',
        'fechaCompromiso',
        'plazo'
    ];

    // Relaciones
    public function cuota()
    {
        return $this->belongsTo(PlanPago::class, 'idPlanPago', 'idPlanPago');
    }

    public function pagoCredito()
    {
        return $this->hasMany(pagoCredito::class, 'idComp','idComp');
    }
}