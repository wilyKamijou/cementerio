<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $primaryKey = 'idRol';
    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    // Relaciones
    public function usuarios()
    {
        return $this->hasMany(User::class, 'idRol', 'idRol');
    }

    public function rolPermisos()
    {
        return $this->hasMany(rolPermiso::class, 'idRol', 'idRol');
    }
}