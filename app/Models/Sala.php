<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
