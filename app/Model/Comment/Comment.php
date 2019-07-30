<?php

namespace App\Model\Comment;

use App\Model\Like\Like;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id', 'comment', 'commentable_id', 'commentable_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)
            ->with(['specific', 'avatar']);
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function answers(){
        return $this->hasMany(Reply::class)
            ->with(['user.avatar', 'user.specific']);
    }

    public function deleteReply($id){
        Reply::where('comment_id', $id)
            ->delete();
    }

    //likes up
    public function likesU(){
        return $this->hasMany(Like::class, 'likeable_id', 'id')
            ->where(['likeable_type' => 'COMMENT', 'like' => 1]);
    }

    //likes down
    public function likesD(){
        return $this->hasMany(Like::class, 'likeable_id', 'id')
            ->where(['likeable_type' => 'COMMENT', 'like' => 0]);
    }
}
