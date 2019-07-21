<?php

namespace App\Policies\Pages;

use App\User;
use App\Model\Page\Article;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the article.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Page\Article  $article
     * @return mixed
     */
    public function update(User $user, Article $article)
    {
        return $user->id === $article->user_id;
    }

    /**
     * Determine whether the user can delete the article.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Page\Article  $article
     * @return mixed
     */
    public function destroy(User $user, Article $article)
    {
        return $user->id === $article->user_id;
    }
}
