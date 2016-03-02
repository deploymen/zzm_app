<?php

Route::group(['prefix' => 'cron/leaderboard'], function(){
	Route::get('/clean', 'CronController@s1001_leaderboard_clean');
});

Route::group(['prefix' => '1.0/cron'], function(){
	Route::get('/planet-available', 'CronController@s1001_planet_available');
	Route::get('/question-cache', 'CronController@s1002_question_cache');
});

