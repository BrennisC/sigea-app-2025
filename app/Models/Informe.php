<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informe extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'informes';

    protected $fillable = [
        'actividad_id',
        'user_id',
        'titulo',
        'descripcion',
        'archivo_url',
        'tipo_archivo',
        'fecha_subida',
    ];

    protected $casts = [
        'fecha_subida' => 'date',
    ];

    /**
     * Actividad del informe
     */
    public function actividad()
    {
        return $this->belongsTo(Actividad::class);
    }

    /**
     * Usuario que subió el informe
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
