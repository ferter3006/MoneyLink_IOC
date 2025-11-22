<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaObjective extends Model
{
    protected $fillable = [
        'sala_id',
        'amount',
        'date',
    ];

    // Para que Eloquent trate 'date' como una instancia de Carbon
    protected $casts = [
        'date' => 'date',
    ];
}
