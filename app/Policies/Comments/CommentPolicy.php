<?php

namespace App\Policies\Comments;

use App\Model\Comment\Comment;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
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

    public function update(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id;
    }

    public function destroy(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id;
    }
}
