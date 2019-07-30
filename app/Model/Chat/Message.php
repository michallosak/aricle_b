<?php

namespace App\Model\Chat;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'from', 'to', 'message'
    ];
}
