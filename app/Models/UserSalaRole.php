<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Clase que representa las instancias de usuario en cada sala y rol que tienen en esa sala.
// La Clave primaria es el conjunto de user_id, sala_id y role_id
// PAra que no pueda haver dos instancias de un usuario en la misma sala. 

class UserSalaRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sala_id',
        'role_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sala()
    {
        return $this->belongsTo(Sala::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
