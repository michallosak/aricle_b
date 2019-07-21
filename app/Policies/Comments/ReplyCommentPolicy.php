<?php

namespace App\Policies\Comments;

use App\Model\Comment\Reply;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyCommentPolicy
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

    public function update(User $user, Reply $reply)
    {
        return $user->id === $reply->user_id;
    }

    public function destroy(User $user, Reply $reply)
    {
        return $user->id === $reply->user_id;
    }
}
