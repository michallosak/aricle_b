<?php

namespace App\Http\Controllers\Likes;

use App\Http\Requests\Likes\LikeRequest;
use App\Http\Controllers\Controller;
use App\Model\Like\Like;

class LikesController extends Controller
{
    public function store(LikeRequest $r)
    {
        $data = [
            'likeable_id' => $r->likeable_id,
            'likeable_type' => $r->likeable_type,
            'like' => $r->like
        ];
        $like = new Like();
        $like->setLike($data);
        return 'Like added!';
    }

    public function destroy(Like $like)
    {
        $like->delete();
    }
}
