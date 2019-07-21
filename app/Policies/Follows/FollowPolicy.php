<?php

namespace App\Policies\Follows;

use App\Model\Follow\Follow;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FollowPolicy
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

    public function destroy(User $user, Follow $follow){
        return $user->id === $follow->user_id;
    }
}
