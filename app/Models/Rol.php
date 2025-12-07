<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'roles';

    protected $fillable = [
        'nombre_rol',
        'descripcion',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Usuarios que tienen este rol
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles', 'rol_id', 'user_id')->withTimestamps();
    }
}
