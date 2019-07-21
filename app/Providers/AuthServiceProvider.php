<?php

namespace App\Providers;

use App\Model\Comment\Comment;
use App\Model\Comment\Reply;
use App\Model\Follow\Follow;
use App\Model\Like\Like;
use App\Model\Page\Article;
use App\Policies\Comments\CommentPolicy;
use App\Policies\Comments\ReplyCommentPolicy;
use App\Policies\Follows\FollowPolicy;
use App\Policies\Likes\LikePolicy;
use App\Policies\Pages\ArticlePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Article::class => ArticlePolicy::class,
        Comment::class => CommentPolicy::class,
        Reply::class => ReplyCommentPolicy::class,
        Follow::class => FollowPolicy::class,
        Like::class => LikePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
    }
}
