<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'sesiones';

    protected $fillable = [
        'actividad_id',
        'nombre',
        'descripcion',
        'fecha_hora_inicio',
        'fecha_hora_fin',
        'duracion_minutos',
        'ubicacion',
        'url_virtual',
        'instructor',
        'asistencia_tomada',
    ];

    protected $casts = [
        'fecha_hora_inicio' => 'datetime',
        'fecha_hora_fin' => 'datetime',
        'asistencia_tomada' => 'boolean',
    ];

    /**
     * Actividad a la que pertenece la sesión
     */
    public function actividad()
    {
        return $this->belongsTo(Actividad::class);
    }

    /**
     * Asistencias registradas en esta sesión
     */
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }
}
