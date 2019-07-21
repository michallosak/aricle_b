<?php

namespace App\Model\User;

use App\User;
use Illuminate\Database\Eloquent\Model;

class PhotosUser extends Model
{
    protected $fillable = [
        'user_id', 'src', 'type'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
