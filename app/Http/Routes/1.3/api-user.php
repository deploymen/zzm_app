<?php

// =======================================================================//
// ! Parent | Teacher												      //
// =======================================================================//

Route::group(['middleware' => 'auth.user'], function () {
    Route::group(['middleware' => 'auth.parent'], function () {
        Route::group(['prefix' => '/profiles'], function () {
            Route::get('/', 'ApiProfileController@get');
            Route::post('/', 'ApiProfileController@createV1_3');
            Route::get('/{id}', 'ApiProfileController@getProfile');
            Route::put('/{id}/edit', 'ApiProfileController@update');
            Route::delete('/{id}', 'ApiProfileController@delete');

            Route::post('/create-bulk', 'ApiProfileController@createBulk');
        });
    });
});

// =======================================================================//
// ! Teacher only 														  //
// =======================================================================//
Route::group(['middleware' => 'auth.user'], function () {
    Route::group(['middleware' => 'auth.teacher'], function () {
        Route::group(['prefix' => 'class'], function () {
            Route::get('/', 'ApiClassController@get');
            Route::post('/', 'ApiClassController@create');
            Route::put('/{id}', 'ApiClassController@update');
            Route::delete('/{id}', 'ApiClassController@delete');

            Route::put('/add-to-class', 'ApiClassController@addProfile');
            Route::get('/{id}/profiles', 'ApiClassController@getProfile');

            Route::get('/{class_id}', 'ApiClassController@getGameClass');
        });
    });
});

Route::group(['middleware' => 'auth.user'], function () {
    Route::group(['middleware' => 'auth.parent'], function () {
        Route::group(['prefix' => 'user'], function () {
            Route::put('/{id}/edit', 'AuthUserController@update');
        });
    });
});

Route::group(['middleware' => 'auth.user'], function () {
    Route::group(['prefix' => 'profiles'], function () {
        /* fade domain name */
        Route::get('/result/only-system', 'ResultController@onlySystemV1_1');
        Route::get('/result/only-planet', 'ResultController@onlyPlanetV1_1');
        Route::get('/result/only-questions', 'ResultController@onlyQuestions');

        Route::get('/report/profile-details', 'ApiProfileController@profileDetails');
    });
});
Route::get('set/nick', 'ApiProfileController@getNick');

//third party login
Route::get('auth/facebook', 'AuthUserController@redirectToProvider');
Route::get('auth/facebook/callback', 'AuthUserController@handleProviderCallback');
Route::post('auth/facebook/signup', 'AuthUserController@facebookSignUp');

Route::group(['middleware' => 'auth.user'], function () {
    Route::delete('remove/account', 'AuthUserController@deleteAccount');
    Route::get('user/check-user-flag', 'AuthUserController@checkUserFlag');
});

