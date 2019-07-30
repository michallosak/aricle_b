<?php

namespace App\Http\Controllers\Follows;

use App\Http\Requests\Follows\FollowRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\Pages\ArticlesResource;
use App\Model\Follow\Follow;
use Illuminate\Support\Facades\Auth;

class FollowsArticleController extends Controller
{
    public function index(){
        $articles = Follow::with(['articles'])
            ->where(['user_id' => Auth::id(), 'followable_type' => 'ARTICLE'])
            ->paginate(20);
        return ArticlesResource::collection($articles);
    }

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
        return true;
    }

}
