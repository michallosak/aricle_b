<?php

namespace App\Policies\Categories;

use App\Model\Category\Category;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
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

    public function update(User $user, Category $category)
    {
        return $user->id === $category->user_id;
    }

    public function destroy(User $user, Category $category)
    {
        return $user->id === $category->user_id;
    }
}
