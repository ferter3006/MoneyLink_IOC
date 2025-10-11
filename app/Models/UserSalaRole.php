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
