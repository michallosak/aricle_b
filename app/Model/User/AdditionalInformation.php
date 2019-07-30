<?php

namespace App\Model\User;

use App\User;
use Illuminate\Database\Eloquent\Model;

class AdditionalInformation extends Model
{
    protected $fillable = [
        'user_id',
        'interests',
        'description',
        'add_information',
        'city'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
