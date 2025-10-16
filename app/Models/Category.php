<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Category. Clase que representa las categorías de los tiquets, sin más. xD
 * @author Lluís Ferrater
 * @version 1.0
 */
class Category extends Model
{
    protected $fillable = [
        'name'
    ];
}
