<?php

namespace App\Http\Controllers\User;

use App\Http\Resources\Files\Photos\UserPhotosResource;
use App\Http\Resources\Friends\FriendsResource;
use App\Http\Resources\Pages\ArticlesResource;
use App\Http\Resources\User\UserResource;
use App\Model\Friend\Friend;
use App\Model\Page\Article;
use App\Http\Controllers\Controller;
use App\Model\User\PhotosUser;
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
        $user = User::with(['specific', 'avatar', 'photos', 'categories', 'follows', 'inf'])
            ->where('id', $id)
            ->first();
        return new UserResource($user);
    }

    public function friendsProfile($id){
        $friends = Friend::with(['user', 'friend'])
            ->where(['user_id' => $id, 'status' => 2])
            ->orWhere(['friend_id' => $id, 'status' => 2])
            ->orderBy('id', 'DESC')
            ->paginate(20);
        return FriendsResource::collection($friends);
    }

    public function photosProfile($id){
        $photos = PhotosUser::where(['user_id' => $id, 'type' => 'PHOTO'])
            ->orderBy('id', 'DESC')
            ->get();
        return UserPhotosResource::collection($photos);
    }
}
