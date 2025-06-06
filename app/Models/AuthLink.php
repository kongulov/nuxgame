<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthLink extends Model
{
    protected $fillable = [
        'user_id',
        'token',
        'expires_at',
        'is_deactivated'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_deactivated' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
