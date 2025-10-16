<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Sala. Clase que representa las salas de los usuarios.
 * @author Lluís Ferrater
 * @version 1.0
 */
class Sala extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function tiquets()
    {
        return $this->hasMany(Tiquet::class);
    }


}
