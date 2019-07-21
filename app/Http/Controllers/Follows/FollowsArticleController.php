<?php

namespace App\Http\Controllers\Follows;

use App\Http\Requests\Follows\FollowRequest;
use App\Http\Controllers\Controller;
use App\Model\Follow\Follow;

class FollowsArticleController extends Controller
{
    public function store(FollowRequest $r)
    {
        $data = [
            'followable_id' => $r->followable_id,
            'followable_type' => 'ARTICLE'
        ];
        $follow = new Follow();
        $follow->setFollow($data);
    }

    public function destroy(Follow $follow){
        $follow->delete();
    }

}
