<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tiquet extends Model
{
    protected $fillable= [
        'user_id',
        'sala_id',
        'category_id',
        'tipo',
        'description',
        'amount'
    ];

    public function sala()
    {
        return $this->belongsTo(Sala::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
