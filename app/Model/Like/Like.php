<?php

namespace App\Model\Like;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Like extends Model
{

    protected $fillable = [
        'user_id', 'likeable_id', 'likeable_type', 'like'
    ];

    public function setLike($data)
    {

        Like::where(['user_id' => Auth::id(), 'likeable_id' => $data['likeable_id']])->delete();
        Like::create([
            'user_id' => Auth::id(),
            'likeable_id' => $data['likeable_id'],
            'likeable_type' => $data['likeable_type'],
            'like' => $data['like']
        ]);
    }
}
