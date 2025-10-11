<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantillaTiquet extends Model
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
