<?php
Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::get('articles', 'Pages\Articles\ArticlesController@index');
Route::get('article/{id}', 'Pages\Articles\ArticlesController@view');
Route::get('comments-article/{id}', 'Comments\CommentsArticleController@index');
Route::get('categories', 'Categories\CategoryController@index');
Route::get('articles-this-category/{id}', 'Pages\Articles\SidebarArticleController@articlesInCategory');
Route::get('articles-category/{id}', 'Categories\CategoryController@articles');
Route::get('search-user', 'Search\SearchController@searchUser');
// profile ($id)
Route::group(['prefix' => 'profile'], function (){
    Route::get('user/{id}', 'User\ProfilController@getUser');
    Route::get('articles/{id}', 'User\ProfilController@articlesProfil');
    Route::get('friends/{id}', 'User\ProfilController@friendsProfile');
    Route::get('photos/{id}', 'User\ProfilController@photosProfile');
});
// logged
Route::group(['prefix' => 'auth'], function () {
    Route::group(['middleware' => 'auth:api'], function () {

        // logged && un activated
        Route::post('activate-account', 'Auth\ActivateController@activate');
        Route::get('logout', 'Auth\LogoutController@logout');

        // logged user
        Route::get('user', 'User\UserController@user');


        // send verify key
        Route::post('send-verify-key', 'Auth\VerifyController@verify');


        //activated account && logged
        Route::group(['middleware' => 'activated'], function (){

            // article
            Route::apiResource('article', 'Pages\Articles\ArticlesController');
            Route::get('articles', 'User\UserController@articlesUser');

            // comment
            Route::apiResource('comment-article', 'Comments\CommentsArticleController');
            Route::apiResource('reply-com-article', 'Comments\AnswersCommentController');
            Route::delete('com-remove/{comment}', 'Comments\CommentsArticleController@destroy');
            Route::patch('comment-edit/{comment}', 'Comments\CommentsArticleController@update');
            Route::patch('reply-com-edit/{reply}', 'Comments\AnswersCommentController@update');
            Route::delete('reply-com-remove/{reply}', 'Comments\AnswersCommentController@destroy');

            // files
            Route::apiResource('article-img', 'Files\ArticleImagesController');

            // follows
            Route::apiResource('follow-article', 'Follows\FollowsArticleController');
            Route::get('followed-articles', 'Follows\FollowsArticleController@index');
            Route::delete('follow-article-delete/{follow}', 'Follows\FollowsArticleController@destroy');

            // categories
            Route::apiResource('category', 'Categories\CategoryController');

            // friends
            Route::post('friends/add/{id}', 'Friends\FriendsController@sendInvitation');
            Route::get('friends/sent-invitations', 'Friends\FriendsController@sentInvitations');
            Route::post('friends/accept', 'Friends\FriendsController@acceptInvitation');
            Route::get('friends/waiting-acceptance', 'Friends\FriendsController@waitingInvitations');
            Route::get('friends', 'Friends\FriendsController@friends');
            Route::delete('friends/delete/{friend}', 'Friends\FriendsController@destroy');

            // setting
            Route::post('edit-email', 'User\Settings\EditDataController@editEmail');
            Route::post('edit-data', 'User\Settings\EditDataController@editBasicData');
            Route::post('edit-nick', 'User\Settings\EditDataController@editUsername');
            Route::post('edit-additional-data', 'User\Settings\EditDataController@editAdditionalData');

            // privacy
            Route::put('set-privacy', 'User\Settings\PrivacyController@setPrivacy');
            Route::get('settings-privacy', 'User\Settings\PrivacyController@settingsPrivacy');
            Route::put('restart-privacy', 'User\Settings\PrivacyController@restartPrivacy');

            Route::post('like', 'Likes\LikesController@store');

            Route::group(['prefix' => 'chat'], function (){
                Route::get('all-users', 'Chat\ChatController@getUsers');
                Route::get('conversation/{id}', 'Chat\ChatController@getMessagesFor');
                Route::post('send-message', 'Chat\ChatController@send');
            });
            Route::group(['prefix' => 'photo'], function (){
                Route::get('all', 'Files\Photos\UserPhotosController@index');
                Route::post('add', 'Files\Photos\UserPhotosController@store');
                Route::delete('delete/{photo}', 'Files\Photos\UserPhotosController@destroy');
            });

        });

    });
});
