<?php

namespace App\Model\Tag;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Tag extends Model
{
    protected $fillable = [
        'user_id', 'tags', 'tagtable_id', 'tagtable_type'
    ];

    public function tagtable(){
        return $this->morphTo();
    }

    public function setTags($tags, $dataTag){
        Tag::create([
            'user_id' => Auth::id(),
            'tags' => $tags['tags'],
            'tagtable_id' => $dataTag['tagtable_id'],
            'tagtable_type' => $dataTag['tagtable_type']
        ]);
    }
}
