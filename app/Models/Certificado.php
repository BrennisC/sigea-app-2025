<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Certificado extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'certificados';

    protected $fillable = [
        'inscripcion_id',
        'actividad_id',
        'user_id',
        'codigo_validacion',
        'fecha_emision',
        'url_pdf',
        'porcentaje_asistencia',
        'horas_certificadas',
        'generado_por',
        'activo',
    ];

    protected $casts = [
        'fecha_emision' => 'date',
        'porcentaje_asistencia' => 'decimal:2',
        'activo' => 'boolean',
    ];

    /**
     * Generar código de validación único
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($certificado) {
            if (empty($certificado->codigo_validacion)) {
                $certificado->codigo_validacion = strtoupper(Str::random(10));
            }
        });
    }

    /**
     * Inscripción asociada
     */
    public function inscripcion()
    {
        return $this->belongsTo(Inscripcion::class);
    }

    /**
     * Actividad del certificado
     */
    public function actividad()
    {
        return $this->belongsTo(Actividad::class);
    }

    /**
     * Usuario que recibe el certificado
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Usuario que generó el certificado
     */
    public function generadoPor()
    {
        return $this->belongsTo(User::class, 'generado_por');
    }

    /**
     * Validaciones del certificado
     */
    public function validaciones()
    {
        return $this->hasMany(Validacion::class);
    }
}
