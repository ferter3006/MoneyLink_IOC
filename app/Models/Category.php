<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Clase que representa las categorías de los tiquets, sin más. xD
class Category extends Model
{
    protected $fillable = [
        'name'
    ];
}
