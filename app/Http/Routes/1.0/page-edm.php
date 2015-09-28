<?php

/*Route::get('/', function(){ return Redirect::to('/pre-launch'); });*/

Route::group(['prefix' => 'edm'], function(){

	Route::get('/', function(){ return view('emails.edm-index'); });
	Route::get('/account-activation', function(){ return view('emails.account-activation-sample'); });
	Route::get('/forgot-password', function(){ return view('emails.forgot-password-sample'); });
	Route::get('/invitation', function(){ return view('emails.invitation-sample'); });
	Route::get('/prelaunch-thank-you', function(){ return view('emails.prelaunch-thank-you-sample'); });

	Route::get('/set-password-app-signup', function(){ return view('emails.set-password-app-signup-sample'); });
});
 