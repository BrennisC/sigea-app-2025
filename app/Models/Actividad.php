<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'actividades';

    protected $fillable = [
        'nombre',
        'descripcion',
        'organizador_id',
        'tipo_id',
        'estado_id',
        'fecha_inicio',
        'fecha_fin',
        'modalidad',
        'ubicacion',
        'url_virtual',
        'precio',
        'cupo_maximo',
        'horas_totales',
        'porcentaje_asistencia_minima',
        'imagen_url',
        'activo',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'precio' => 'decimal:2',
        'porcentaje_asistencia_minima' => 'decimal:2',
        'activo' => 'boolean',
    ];

    /**
     * Organizador de la actividad
     */
    public function organizador()
    {
        return $this->belongsTo(User::class, 'organizador_id');
    }

    /**
     * Tipo de actividad
     */
    public function tipo()
    {
        return $this->belongsTo(Tipo::class);
    }

    /**
     * Estado de la actividad
     */
    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    /**
     * Sesiones de la actividad
     */
    public function sesiones()
    {
        return $this->hasMany(Sesion::class);
    }

    /**
     * Inscripciones a la actividad
     */
    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class);
    }

    /**
     * Certificados emitidos para esta actividad
     */
    public function certificados()
    {
        return $this->hasMany(Certificado::class);
    }

    /**
     * Informes de la actividad
     */
    public function informes()
    {
        return $this->hasMany(Informe::class);
    }

    /**
     * Participantes inscritos (usuarios a través de inscripciones)
     */
    public function participantes()
    {
        return $this->belongsToMany(User::class, 'inscripciones', 'actividad_id', 'user_id')
            ->withTimestamps()
            ->withPivot('estado_id', 'fecha_inscripcion', 'pago_requerido', 'pago_completado');
    }
}
