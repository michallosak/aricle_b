<?php

namespace App\Http\Controllers\Search;

use App\Http\Resources\User\UserResource;
use App\User;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function searchUser(){
        $users = User::with(['avatar', 'specific'])
            ->orderBy('id', 'DESC')
            ->paginate(20);
        return UserResource::collection($users);
    }
}
