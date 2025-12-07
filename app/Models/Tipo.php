<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'tipos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'categoria',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];
}
