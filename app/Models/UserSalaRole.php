<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSalaRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sala_id',
        'role_id'
    ];
}
