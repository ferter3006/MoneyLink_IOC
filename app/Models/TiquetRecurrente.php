<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Clase que representa los tiquets recurrentes de los usuarios
// Esta clase solo es usada para guardar las plantillas de tiquets recurrentes
// Si se genera un tiquet de estos, se creará un tiquet en la tabla tiquets (copiando los datos de esta plantilla)
// Es así por si se elimina o modifica esta plantilla de tiquet recurrente (por ejemplo el sueldo mensual augmenta)
// no se modifican los tiquets ya creados de meses anteriores
class TiquetRecurrente extends Model
{
    protected $fillable = [
        'user_id',
        'sala_id',
        'category_id',
        'es_ingreso',
        'description',
        'amount',
        'recurrencia_es_mensual', // true o false
        'recurrencia_dia_activacion', // que dia del mes se activa
        'ultima_activacion'
    ];

    protected $casts = [
        'ultima_activacion' => 'datetime',
    ];
    public function sala()
    {
        return $this->belongsTo(Sala::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
