<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantillaTiquet extends Model
{
    protected $fillable = [
        'user_id',
        'sala_id',
        'category_id',
        'tipo',
        'description',
        'amount',
        'recurrencia' // 1 = mensual, 2 = semanal, 3 = diario (por ejemplo, falta definir aún)
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
