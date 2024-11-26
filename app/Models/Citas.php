<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Citas extends Model
{
    use HasFactory;

    /**
     * La tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'citas';

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'apellido',
        'tipo_documento',
        'numero_documento',
        'tipo_servicio',
        'dia',
        'hora',
    ];

    /**
     * Los valores predeterminados de los atributos.
     *
     * @var array
     */
    protected $attributes = [
        'tipo_documento' => 'cc', // Valor predeterminado (opcional)
        'tipo_servicio' => 'revision general', // Valor predeterminado (opcional)
    ];

    /**
     * Las reglas de casteo de atributos.
     *
     * @var array
     */
    protected $casts = [
        'dia' => 'date',
        'hora' => 'datetime:H:i',
    ];
}
