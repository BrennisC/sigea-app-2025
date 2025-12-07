<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Validacion extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'validaciones';

    protected $fillable = [
        'certificado_id',
        'ip_address',
        'fecha_hora_validacion',
        'user_agent',
    ];

    protected $casts = [
        'fecha_hora_validacion' => 'datetime',
    ];

    /**
     * Certificado validado
     */
    public function certificado()
    {
        return $this->belongsTo(Certificado::class);
    }
}
