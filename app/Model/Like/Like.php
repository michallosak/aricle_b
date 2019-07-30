<?php

namespace App\Model\Like;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Like extends Model
{

    protected $fillable = [
        'user_id', 'likeable_id', 'likeable_type', 'like'
    ];


    public function setLike($data){
        $likeUpCheck = Like::where(['user_id' => Auth::id(), 'likeable_id' => $data['likeable_id']])->first();
        $like = Like::where(['user_id' => Auth::id(), 'likeable_id' => $data['likeable_id']])->value('like');
        if ($likeUpCheck){
            if ($like === $data['like']){
                Like::where(['user_id' => Auth::id(), 'likeable_id' => $data['likeable_id']])->delete();
                return 'Like deleted!';
            }else{
                Like::where(['user_id' => Auth::id(), 'likeable_id' => $data['likeable_id']])->delete();
                $this->set($data);
            }
        }
        else{
            $this->set($data);
        }
    }

    private function set($data){
        Like::create([
            'user_id' => Auth::id(),
            'likeable_id' => $data['likeable_id'],
            'likeable_type' => $data['likeable_type'],
            'like' => $data['like']
        ]);
    }
}
