<?php

namespace App\Model\Comment;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id', 'comment', 'commentable_id', 'commentable_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function answers(){
        return $this->hasMany(Reply::class);
    }

    public function deleteReply($id){
        Reply::where('comment_id', $id)
            ->delete();
    }
}
