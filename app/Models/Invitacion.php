<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Invitacion. Clase que representa las invitaciones de los usuarios.
 * @author Lluís Ferrater
 * @version 1.0
 */
class Invitacion extends Model
{
    protected $fillable = [
        'user_invitador_id',
        'user_invitado_id',
        'sala_id',
    ];

    public function invitador()
    {
        return $this->belongsTo(User::class, 'user_invitador_id');
    }

    public function invitado()
    {
        return $this->belongsTo(User::class, 'user_invitado_id');
    }

    public function sala()
    {
        return $this->belongsTo(Sala::class);
    }
}
