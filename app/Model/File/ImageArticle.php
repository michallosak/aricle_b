<?php

namespace App\Model\File;

use Illuminate\Database\Eloquent\Model;

class ImageArticle extends Model
{
    protected $fillable = [
        'user_id', 'article_id', 'src'
    ];
}
