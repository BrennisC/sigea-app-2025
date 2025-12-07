<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'notificaciones';

    protected $fillable = [
        'user_id',
        'titulo',
        'mensaje',
        'tipo',
        'enlace',
        'leida',
        'fecha_leida',
    ];

    protected $casts = [
        'leida' => 'boolean',
        'fecha_leida' => 'datetime',
    ];

    /**
     * Usuario que recibe la notificación
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Marcar como leída
     */
    public function marcarComoLeida()
    {
        $this->update([
            'leida' => true,
            'fecha_leida' => now(),
        ]);
    }
}
