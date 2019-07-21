<?php

namespace App\Model\Category;

use App\Model\Page\Article;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'user_id', 'name'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function article(){
        return $this->belongsTo(Article::class);
    }
}
