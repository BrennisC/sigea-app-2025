<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'telefono',
        'direccion',
        'documento_identidad',
        'activo',
    ];

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
            'activo' => 'boolean',
        ];
    }

    /**
     * Relación muchos a muchos con roles
     */
    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'user_roles', 'user_id', 'rol_id')->withTimestamps();
    }

    /**
     * Verificar si el usuario tiene un rol específico
     */
    public function tieneRol(string $rolNombre): bool
    {
        return $this->roles->contains('nombre_rol', $rolNombre);
    }

    /**
     * Verificar si el usuario tiene alguno de los roles especificados
     */
    public function tieneAlgunRol(array $roles): bool
    {
        return $this->roles->whereIn('nombre_rol', $roles)->isNotEmpty();
    }

    /**
     * Inscripciones del usuario
     */
    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class);
    }

    /**
     * Actividades organizadas por el usuario
     */
    public function actividadesOrganizadas()
    {
        return $this->hasMany(Actividad::class, 'organizador_id');
    }

    /**
     * Certificados del usuario
     */
    public function certificados()
    {
        return $this->hasMany(Certificado::class);
    }

    /**
     * Notificaciones del usuario
     */
    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class);
    }

    /**
     * Informes subidos por el usuario
     */
    public function informes()
    {
        return $this->hasMany(Informe::class);
    }
}
