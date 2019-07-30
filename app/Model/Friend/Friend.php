<?php

namespace App\Model\Friend;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $fillable = [
        'user_id', 'friend_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')
            ->with(['avatar', 'specific']);
    }

    public function friend()
    {
        return $this->belongsTo(User::class, 'friend_id', 'id')
            ->with(['avatar', 'specific']);
    }
}
