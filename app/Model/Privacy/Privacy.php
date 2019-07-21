<?php

namespace App\Model\Privacy;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Privacy extends Model
{
    protected $fillable = [
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
