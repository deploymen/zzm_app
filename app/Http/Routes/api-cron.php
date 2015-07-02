<?php

Route::group(['prefix' => 'cron/leaderboard'], function(){
	Route::get('/clean', 'CronController@s1001_leaderboard_clean');

});
