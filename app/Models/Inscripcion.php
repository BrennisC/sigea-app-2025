<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'inscripciones';

    protected $fillable = [
        'user_id',
        'actividad_id',
        'estado_id',
        'fecha_inscripcion',
        'pago_requerido',
        'pago_completado',
        'observaciones',
    ];

    protected $casts = [
        'fecha_inscripcion' => 'date',
        'pago_requerido' => 'boolean',
        'pago_completado' => 'boolean',
    ];

    /**
     * Usuario inscrito
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Actividad a la que está inscrito
     */
    public function actividad()
    {
        return $this->belongsTo(Actividad::class);
    }

    /**
     * Estado de la inscripción
     */
    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    /**
     * Asistencias del participante
     */
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

    /**
     * Pagos asociados a la inscripción
     */
    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    /**
     * Certificado generado para esta inscripción
     */
    public function certificado()
    {
        return $this->hasOne(Certificado::class);
    }
    /**
     * Calcular porcentaje de asistencia
     */
    public function calcularPorcentajeAsistencia()
    {
        $totalSesiones = $this->actividad->sesiones()->count();
        
        if ($totalSesiones == 0) {
            return 0;
        }

        $asistencias = $this->asistencias()->where('presente', true)->count();

        return ($asistencias / $totalSesiones) * 100;
    }
}
