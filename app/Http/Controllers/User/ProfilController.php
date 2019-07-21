<?php

namespace App\Http\Controllers\User;

use App\Http\Resources\Pages\ArticlesResource;
use App\Http\Resources\User\UserResource;
use App\Model\Page\Article;
use App\Http\Controllers\Controller;
use App\User;

class ProfilController extends Controller
{

    public function articlesProfil($id){
        $articles = Article::with(['categories'])
            ->where(['user_id' => $id, 'status' => 1])
            ->orderBy('id', 'DESC')
            ->paginate(20);
        return ArticlesResource::collection($articles);
    }

    public function getUser($id)
    {
        $user = User::with(['specific', 'avatar', 'photos', 'categories', 'follows'])
            ->where('id', $id)
            ->first();
        return new UserResource($user);
    }
}
