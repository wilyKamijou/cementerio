<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolPermiso extends Model
{
    use HasFactory;

    protected $table = 'rolPermiso';
    protected $primaryKey = 'id';
    protected $fillable = [
        'idRol',
        'idPer'
    ];

    // Relaciones
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'idRol', 'idRol');
    }

    public function permiso()
    {
        return $this->belongsTo(Permiso::class, 'idPer', 'idPer');
    }
}
