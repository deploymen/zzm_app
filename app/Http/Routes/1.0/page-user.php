<?php

Route::group(['prefix' => 'user'], function(){

	Route::get('/signup', function(){ return view('contents.website.signup'); });
	Route::get('/signin', function(){ return view('contents.website.signin'); });
	Route::get('/forgot-password', function(){ return view('contents.website.forgot-password'); });
	Route::get('/reset-password', function(){ return view('contents.website.reset-password'); });
	
	Route::group(['middleware' => 'auth.user'], function () {
		Route::group(['middleware' => 'auth.parent'], function () {
			Route::get('/home', function(){ return view('contents.website.index'); });
			Route::get('/account', function(){ return view('contents.website.user-account'); });
			Route::get('/change-password', function(){ return view('contents.website.user-change-password'); });
			Route::get('/profiles', function(){ return view('contents.website.profiles'); });
			Route::get('/profile-inner', function(){ return view('contents.website.profile-inner'); });

			Route::get('/profiles/{profile_id}/edit', 'PageController@editProfile');
			Route::get('/profiles/{profile_id}/results', 'PageController@resultProfile');
			
			Route::get('/classes', function(){ return view('contents.website.classes'); });
			Route::get('/reports', function(){ return view('contents.website.reports'); });
			Route::get('/new-quiz', function(){ return view('contents.website.user-create-quiz'); });
			Route::get('/quizzes', function(){ return view('contents.website.user-quizzes'); });
			Route::get('/results2', function(){ return view('contents.website.results-2'); });
		});
	});
});
