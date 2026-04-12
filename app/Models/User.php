<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        //aparte esto
        'idEmpleado',
        'idCliente',
        'idRol'
    ];

    public function empleados()
    {
        return $this->belongsTo(Empleado::class, 'idEmpleado', 'idEmpleado');
    }
    public function clientes()
    {
        return  $this->belongsTo(Cliente::class, 'idCliente', 'idCliente');
    }
    public function roles()
    {
        return $this->belongsTo(rol::class, 'idRol', 'idRol');
    }
    public function tienePermiso($permisoNombre)
    {
        $permiso = Permiso::where('nombre', $permisoNombre)->first();

        if (!$permiso) {
            return false;
        }

        return RolPermiso::where('idRol', $this->idRol)
            ->where('idPer', $permiso->idPer)
            ->exists();
    }
    /**
     * Verificar si el usuario tiene un rol específico
     */
    public function tieneRol($rolNombre)
    {
        return $this->rol && $this->rol->nombre === $rolNombre;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
