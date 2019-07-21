<?php

namespace App\Model\Page;

use App\Model\Category\Category;
use App\Model\Comment\Comment;
use App\Model\Follow\Follow;
use App\Model\Like\Like;
use App\Model\Tag\Tag;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    protected $fillable = [
        'user_id', 'category_id', 'title',
        'article', 'comment'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class, 'tagtable_id', 'id')
            ->where('tagtable_type', 'ARTICLE');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'commentable_id', 'id')
            ->where('commentable_type', 'ARTICLE');
    }

    public function follows()
    {
        return $this->hasMany(Follow::class, 'followable_id', 'id')
            ->where('followable_type', 'ARTICLE');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'likeable_id', 'id')
            ->where('likeable_type', 'ARTICLE');
    }

    public function categories(){
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

}
