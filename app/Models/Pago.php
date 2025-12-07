<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pagos';

    protected $fillable = [
        'inscripcion_id',
        'metodo_pago_id',
        'estado_id',
        'monto',
        'fecha_pago',
        'numero_transaccion',
        'comprobante_url',
        'observaciones',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'fecha_pago' => 'date',
    ];

    /**
     * Inscripción asociada al pago
     */
    public function inscripcion()
    {
        return $this->belongsTo(Inscripcion::class);
    }

    /**
     * Método de pago utilizado
     */
    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class);
    }

    /**
     * Estado del pago
     */
    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }
}
