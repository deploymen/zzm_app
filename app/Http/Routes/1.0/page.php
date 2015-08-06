<?php
  
// Route::get('/', function(){ die('www.zapzapmath.com'); });

Route::get('/', function(){ return Redirect::to('/pre-launch'); });

Route::get('/pre-launch', function(){ return view('index'); });

Route::get('/jobs', function(){ return view('website.jobs'); });

Route::get('/index2', function(){ return view('website.index2'); });

Route::get('/terms', function(){ return view('website.terms'); });

Route::get('/privacy', function(){ return view('website.privacy'); });

Route::get('/beta', function(){ return view('website.beta'); });

Route::get('/contributors', function(){ return view('website.contributors'); });

Route::get('/server', function(){ return die(\Config::get('app.version_test')); });

Route::get('/thank-you', function(){ return view('website.thank-you'); });

Route::get('/check/status', 'ApiCheckingController@CheckStatus');


