<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    use HasFactory;
    protected $table = 'permisos';
    protected $primaryKey = 'idPer';
    protected $fillable = [
        'nombre',
        'ruta',
        'descripcion'
    ];

    // Relaciones
    public function rolPermiso()
    {
        return $this->hasMany(rolPermiso::class, 'idPer', 'idPer');
    }
}
