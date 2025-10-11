<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tiquet extends Model
{

    const TIPO_GASTO = 0;
    const TIPO_INGRESO = 1;

    protected $fillable= [
        'user_id',
        'sala_id',
        'category_id',
        'es_ingreso',
        'description',
        'amount'
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
