<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'user_id',
        'token',
        'rand',
        'amount',
        'is_winner',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
