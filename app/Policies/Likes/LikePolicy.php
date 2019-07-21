<?php

namespace App\Policies\Likes;

use App\Model\Like\Like;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LikePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Like $like){
        return $user->id === $like->user_id;
    }

    public function destroy(User $user, Like $like){
        return $user->id === $like->user_id;
    }
}
