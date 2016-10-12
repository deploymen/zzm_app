<?php
// =======================================================================//
// ! Quiz										 			      //
// =======================================================================//

Route::group(['prefix' => 'quiz'], function () {
    Route::get('/load/{difficulty}', 'ApiQuizController@load');
    Route::get('/leaderboard', 'ApiQuizController@getLeaderBoard');
    Route::post('/leaderboard/result', 'ApiQuizController@updateResult');

});


