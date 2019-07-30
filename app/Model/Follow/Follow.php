<?php

namespace App\Model\Follow;

use App\Model\Page\Article;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Follow extends Model
{
    protected $fillable = [
        'user_id', 'followable_id', 'followable_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function followable()
    {
        return $this->morphTo();
    }

    public function setFollow($data)
    {
        $followcheck = Follow::where(['user_id' => Auth::id(), 'followable_id' => $data['followable_id']])->first();
        if ($followcheck) {
            Follow::where(['user_id' => Auth::id(), 'followable_id' => $data['followable_id']])->delete();

            return 'Follow deleted!';
        } else {
           $this->set($data);
        }
    }

    public function articles(){
        return $this->belongsTo(Article::class, 'followable_id', 'id')
            ->with(['user.specific', 'categories'])->where('status', 1);
    }
    private function set($data){
        Follow::create([
            'user_id' => Auth::id(),
            'followable_id' => $data['followable_id'],
            'followable_type' => $data['followable_type']
        ]);
    }
}
