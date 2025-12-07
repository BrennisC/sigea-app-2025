<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'asistencias';

    protected $fillable = [
        'inscripcion_id',
        'sesion_id',
        'presente',
        'fecha_hora_registro',
        'registrado_por',
        'observaciones',
    ];

    protected $casts = [
        'presente' => 'boolean',
        'fecha_hora_registro' => 'datetime',
    ];

    /**
     * Inscripción asociada
     */
    public function inscripcion()
    {
        return $this->belongsTo(Inscripcion::class);
    }

    /**
     * Sesión en la que se registró la asistencia
     */
    public function sesion()
    {
        return $this->belongsTo(Sesion::class);
    }

    /**
     * Usuario que registró la asistencia
     */
    public function registradoPor()
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }
}
