<?php

namespace App\Model\User;

use App\User;
use Illuminate\Database\Eloquent\Model;

class SpecificData extends Model
{
    protected $fillable = [
        'user_id', 'name', 'last_name', 'day_birthday', 'month_birthday', 'year_birthday', 'sex'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
