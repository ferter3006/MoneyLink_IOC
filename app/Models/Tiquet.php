<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Clase que representa los tiquets de los usuarios
class Tiquet extends Model
{

    const TIPO_GASTO = 0;
    const TIPO_INGRESO = 1;

    protected $fillable = [
        'user_id', // foreign key
        'sala_id', // foreign key
        'category_id', // foreign key
        'es_ingreso', // true o false
        'description',
        'amount' // decimal
    ];

    public function sala()
    {
        return $this->belongsTo(Sala::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault();
    }
}
