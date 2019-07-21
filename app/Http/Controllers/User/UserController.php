<?php

namespace App\Http\Controllers\User;

use App\Http\Resources\Pages\ArticlesResource;
use App\Http\Resources\User\UserResource;
use App\Model\Page\Article;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
   // GET DATA LOGGED USER

    public function user(){
        $user = User::with(['specific', 'avatar', 'photos', 'categories', 'follows'])
            ->where('id', Auth::id())
            ->first();
        return new UserResource($user);
    }

    public function articlesUser(){
        $articles = Article::with(['categories'])
            ->where(['status' => 1, 'user_id' => Auth::id()])
            ->orderBy('id', 'DESC')
            ->paginate(20);
        return ArticlesResource::collection($articles);
    }
}
