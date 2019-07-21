<?php

Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::get('articles', 'Pages\Articles\ArticlesController@index');
Route::get('article/{id}', 'Pages\Articles\ArticlesController@view');
Route::get('comments-article/{id}', 'Comments\CommentsArticleController@index');
Route::get('categories', 'Categories\CategoryController@index');

// logged
Route::group(['prefix' => 'auth'], function () {
    Route::group(['middleware' => 'auth:api'], function () {

        // logged && un activated
        Route::post('activate-account', 'Auth\ActivateController@activate');
        Route::get('logout', 'Auth\LogoutController@logout');

        // logged user
        Route::get('user', 'User\UserController@user');

        // profil ($id)
        Route::get('user/{id}', 'User\ProfilControlelr@getUser');
        Route::get('articles-profil/{id}', 'User\ProfilController@articlesProfil');


        //activated account && logged
        Route::group(['middleware' => 'activated'], function (){

            // article
            Route::apiResource('article', 'Pages\Articles\ArticlesController');
            Route::get('articles', 'User\UserController@articlesUser');

            // comment
            Route::apiResource('comment-article', 'Comments\CommentsArticleController');
            Route::apiResource('reply-com-article', 'Comments\AnswersCommentController');
            Route::delete('com-remove/{comment}', 'Comments\CommentsArticleController@destroy');

            // files
            Route::apiResource('article-img', 'Files\ArticleImagesController');

            // follows
            Route::apiResource('follow-article', 'Follows\FollowsArticleController');

            // categories
            Route::apiResource('category', 'Categories\CategoryController');

            // friends
            Route::post('send-invitation', 'Friends\FriendsController@sendInvitation');
            Route::get('sent-invitations', 'Friends\FriendsController@sentInvitations');
            Route::put('accept-invitation', 'Friends\FriendsController@acceptInvitation');
            Route::get('waiting-invitations', 'Friends\FriendsController@waitingInvitations');
            Route::get('friends', 'Friends\FriendsController@friends');

            // setting
            Route::post('edit-email', 'User\Settings\EditDataController@editEmail');
            Route::post('edit-data', 'User\Settings\EditDataController@editBasicData');

            // privacy
            Route::put('set-privacy', 'User\Settings\PrivacyController@setPrivacy');
            Route::get('settings-privacy', 'User\Settings\PrivacyController@settingsPrivacy');
            Route::put('restart-privacy', 'User\Settings\PrivacyController@restartPrivacy');
        });

    });
});
