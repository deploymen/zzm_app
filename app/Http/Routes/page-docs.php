<?php

Route::group(['prefix' => 'docs'], function(){

	Route::get('/index', function(){ return view('contents.docs.index'); });

	Route::get('/list-general', function(){ return view('contents.docs.list-general'); });
	Route::get('/api.auth-sign-up-post', function(){ return view('contents.docs.api-auth-sign-up-post'); });
	Route::get('/api.auth-sign-up-app-post', function(){ return view('contents.docs.api-auth-sign-up-app-post'); });
	Route::get('/api.auth-sign-in-post', function(){ return view('contents.docs.api-auth-sign-in-post'); });
	Route::get('/api.auth-connect-facebook-post', function(){ return view('contents.docs.api-auth-connect-facebook-post'); });
	Route::get('/api.auth-connect-google-post', function(){ return view('contents.docs.api-auth-connect-google-post'); });
	Route::get('/api.auth-activate-get', function(){ return view('contents.docs.api-auth-activate-get'); });
	Route::get('/api.auth-forgot-password-put', function(){ return view('contents.docs.api-auth-forgot-password-put'); });
	Route::get('/api.auth-reset-password-put', function(){ return view('contents.docs.api-auth-reset-password-put'); });
	Route::get('/api.auth-invite-parent-post', function(){ return view('contents.docs.api-auth-invite-parent-post'); });
	Route::get('/api.auth-check-post', function(){ return view('contents.docs.api-auth-check-post'); });
	Route::get('/api.auth-change-password-post', function(){ return view('contents.docs.api-auth-change-password-post'); });
	Route::get('/api.auth-worksheets-post', function(){ return view('contents.docs.api-auth-worksheets-post'); });
	Route::get('/api.auth-launch-notification-post', function(){ return view('contents.docs.api-auth-launch-notification-post'); });


	Route::get('/list-user', function(){ return view('contents.docs.list-user'); });
	Route::get('/api.user-profile-get', function(){ return view('contents.docs.api-user-profile-get'); });
	Route::get('/api.user-profile-post', function(){ return view('contents.docs.api-user-profile-post'); });
	Route::get('/api.user-profile-put', function(){ return view('contents.docs.api-user-profile-put'); });
	Route::get('/api.user-profile-delete', function(){ return view('contents.docs.api-user-profile-delete'); });
	Route::get('/api.user-class-get', function(){ return view('contents.docs.api-user-class-get'); });
	Route::get('/api.user-class-post', function(){ return view('contents.docs.api-user-class-post'); });
	Route::get('/api.user-class-put', function(){ return view('contents.docs.api-user-class-put'); });
	Route::get('/api.user-class-delete', function(){ return view('contents.docs.api-user-class-delete'); });
	Route::get('/api.user-class-profile-post', function(){ return view('contents.docs.api-user-class-profile-post'); });
	Route::get('/api.user-class-profile-put', function(){ return view('contents.docs.api-user-class-profile-put'); });
	Route::get('/api.user-profile-get-one-profile', function(){ return view('contents.docs.api-user-profile-get-one-profile'); });
	Route::get('/api.user-game-profile-put', function(){ return view('contents.docs.api-user-game-profile-put'); });
	Route::get('/api.user-anonymous-game-code-post', function(){ return view('contents.docs.api-user-anonymous-game-code-post'); });
	Route::get('/api.user-verify-code-post', function(){ return view('contents.docs.api-user-verify-code-post'); });
	Route::get('/api.user-profile-transfer-post', function(){ return view('contents.docs.api-user-profile-transfer-post'); });
	Route::get('/api.user-report-profile-details-get', function(){ return view('contents.docs.api-user-report-profile-details-get'); });
	Route::get('/api.user-profiles-result-only-planet-get', function(){ return view('contents.docs.api-user-profiles-result-only-planet-get'); });
	Route::get('/api.user-profiles-result-only-system-get', function(){ return view('contents.docs.api-user-profiles-result-only-system-get'); });
	Route::get('/api.user-profiles-result-only-play-get', function(){ return view('contents.docs.api-user-profiles-result-only-play-get'); });
	Route::get('/api.user-profiles-result-only-questions-get', function(){ return view('contents.docs.api-user-profiles-result-only-questions-get'); });


	Route::get('/list-admin', function(){ return view('contents.docs.list-admin'); });
	Route::get('/api.admin-system-get', function(){ return view('contents.docs.api-admin-system-get'); });
	Route::get('/api.admin-system-post', function(){ return view('contents.docs.api-admin-system-post'); });
	Route::get('/api.admin-system-put', function(){ return view('contents.docs.api-admin-system-put'); });
	Route::get('/api.admin-system-delete', function(){ return view('contents.docs.api-admin-system-delete'); });
	Route::get('/api.admin-planet-get', function(){ return view('contents.docs.api-admin-planet-get'); });
	Route::get('/api.admin-planet-post', function(){ return view('contents.docs.api-admin-planet-post'); });
	Route::get('/api.admin-planet-put', function(){ return view('contents.docs.api-admin-planet-put'); });
	Route::get('/api.admin-planet-delete', function(){ return view('contents.docs.api-admin-planet-delete'); });
	Route::get('/api.admin-questbank-get', function(){ return view('contents.docs.api-admin-questbank-get'); });
	Route::get('/api.admin-questbank-post', function(){ return view('contents.docs.api-admin-questbank-post'); });
	Route::get('/api.admin-questbank-put', function(){ return view('contents.docs.api-admin-questbank-put'); });
	Route::get('/api.admin-questbank-delete', function(){ return view('contents.docs.api-admin-questbank-delete'); });


	Route::get('/list-game', function(){ return view('contents.docs.list-game'); });
	Route::get('/api.game-map-system-post', function(){ return view('contents.docs.api-game-map-system-post'); });
	Route::get('/api.game-map-system-worksheets-post', function(){ return view('contents.docs.api-game-map-system-worksheets-post'); });
	Route::get('/api.game-profile-nick-get', function(){ return view('contents.docs.api-game-profile-nick-get'); });
	Route::get('/api.game-profile-verify-post', function(){ return view('contents.docs.api-game-profile-verify-post'); });
	Route::get('/api.game-leaderboard-world-get', function(){ return view('contents.docs.api-game-leaderboard-world-get'); });
	Route::get('/api.game-leaderboard-system-get', function(){ return view('contents.docs.api-game-leaderboard-system-get'); });
	Route::get('/api.game-leaderboard-planet-get', function(){ return view('contents.docs.api-game-leaderboard-planet-get'); });
	Route::get('/api.version-get', function(){ return view('contents.docs.api-version-get'); });


	Route::get('/api.game-play-request-get-p01-150', function(){ return view('contents.docs.api-game-play-request-get-p01-150'); });
	Route::get('/api.game-play-request-get-p02-103', function(){ return view('contents.docs.api-game-play-request-get-p02-103'); });
	Route::get('/api.game-play-request-get-p02-106', function(){ return view('contents.docs.api-game-play-request-get-p02-106'); });
	Route::get('/api.game-play-request-get-p02-115', function(){ return view('contents.docs.api-game-play-request-get-p02-115'); });
	Route::get('/api.game-play-request-get-p03-166', function(){ return view('contents.docs.api-game-play-request-get-p03-166'); });
	Route::get('/api.game-play-request-get-p03-102', function(){ return view('contents.docs.api-game-play-request-get-p03-102'); });
	Route::get('/api.game-play-request-get-p03-141', function(){ return view('contents.docs.api-game-play-request-get-p03-141'); });
	Route::get('/api.game-play-request-get-p06-155', function(){ return view('contents.docs.api-game-play-request-get-p06-155'); });
	Route::get('/api.game-play-request-get-p06-104', function(){ return view('contents.docs.api-game-play-request-get-p06-104'); });
	Route::get('/api.game-play-request-get-p07-114', function(){ return view('contents.docs.api-game-play-request-get-p07-114'); });
	Route::get('/api.game-play-request-get-p10-105', function(){ return view('contents.docs.api-game-play-request-get-p10-105'); });
	Route::get('/api.game-play-request-get-p10-123', function(){ return view('contents.docs.api-game-play-request-get-p10-123'); });
	Route::get('/api.game-play-request-get-p10-131', function(){ return view('contents.docs.api-game-play-request-get-p10-131'); });
	Route::get('/api.game-play-request-get-p18-129', function(){ return view('contents.docs.api-game-play-request-get-p18-129'); });
	Route::get('/api.game-play-request-get-p23-185', function(){ return view('contents.docs.api-game-play-request-get-p23-185'); });
	Route::get('/api.game-play-request-get-p32-225', function(){ return view('contents.docs.api-game-play-request-get-p32-225'); });
	Route::get('/api.game-play-request-get-p00-228', function(){ return view('contents.docs.api-game-play-request-get-p00-228'); });


	Route::get('/api.game-play-result-post-p00', function(){ return view('contents.docs.api-game-play-result-post-p00'); });
	Route::get('/api.game-play-result-post-p01', function(){ return view('contents.docs.api-game-play-result-post-p01'); });
	Route::get('/api.game-play-result-post-p02', function(){ return view('contents.docs.api-game-play-result-post-p02'); });
	Route::get('/api.game-play-result-post-p03', function(){ return view('contents.docs.api-game-play-result-post-p03'); });
	Route::get('/api.game-play-result-post-p04', function(){ return view('contents.docs.api-game-play-result-post-p04'); });
	Route::get('/api.game-play-result-post-p06', function(){ return view('contents.docs.api-game-play-result-post-p06'); });
	Route::get('/api.game-play-result-post-p07', function(){ return view('contents.docs.api-game-play-result-post-p07'); });
	Route::get('/api.game-play-result-post-p10', function(){ return view('contents.docs.api-game-play-result-post-p10'); });
	Route::get('/api.game-play-result-post-p18', function(){ return view('contents.docs.api-game-play-result-post-p18'); });
	Route::get('/api.game-play-result-post-p23', function(){ return view('contents.docs.api-game-play-result-post-p23'); });
	Route::get('/api.game-play-result-post-p32', function(){ return view('contents.docs.api-game-play-result-post-p32'); });
	Route::get('/api-game-play-result-offline-post', function(){ return view('contents.docs.api-game-play-result-offline-post'); });


	Route::get('/api.game-result-progress-get', function(){ return view('contents.docs.api-game-result-progress-get'); });
	Route::get('/api.game-result-play-get', function(){ return view('contents.docs.api-game-result-play-get'); });
	Route::get('/api.game-user-map-get', function(){ return view('contents.docs.api-game-user-map-get'); });

});
	Route::get('/edm-sample', function(){ return view('emails.edm-index'); });
	Route::get('/edm/account-activation', function(){ return view('emails.account-activation-sample'); });
	Route::get('/edm/forgot-password', function(){ return view('emails.forgot-password-sample'); });
	Route::get('/edm/invitation', function(){ return view('emails.edm-invitation-sample'); });
	Route::get('/edm/prelaunch-thank-you', function(){ return view('emails.prelaunch-thank-you'); });
	Route::get('/edm/set-password-app-signup', function(){ return view('emails.set-password-app-signup'); });