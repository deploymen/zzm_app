<?php
Route::get('/', function () {return die('zzm-api');});

Route::pattern('role', '(parent)|(teacher)|(admin)|(content)|(investor)');

// =======================================================================//
// ! Auth Related												          //
// =======================================================================//
Route::group(['prefix' => 'auth'], function () {
	Route::post('/sign-up', 'AuthUserController@signUp'); //only for parent|teacher
	Route::post('/sign-in', 'AuthUserController@signIn');

	Route::get('/activate/{secret_key}', 'AuthUserController@activate');
	Route::post('/activate-code', 'AuthUserController@ResendACtivateCode');
	Route::put('/forgot-password', 'AuthUserController@forgotPassword');
	Route::put('/reset-password', 'AuthUserController@resetPassword');

	Route::post('/invite-parent', 'AuthUserController@invite');

	Route::group(['middleware' => 'auth.user'], function () {
		Route::post('/change-password', 'AuthUserController@changePassword');
	});
});

// =======================================================================//
// ! Content											          //
// =======================================================================//

//Route::post('/worksheets', 'ApiQuestionBankController@createGameWorksheet');

Route::get('/flag', 'ApiCmsController@getFlag');

Route::group(['prefix' => 'pre-launch'], function () {
	Route::post('/contact-us', 'ApiController@contactUs');
});

Route::any('/subscribe', 'ApiController@subscribe');
Route::get('check-ip-details', 'ApiCheckingController@CheckIpDetails');
Route::get('weekly-report', 'ApiController@weeklyReport');
Route::post('user/invite/teacher' , 'ApiController@inviteTeacher');
Route::get('send-in-blue' , 'ApiController@SendInBlue');

Route::group(['prefix' => 'admin'], function () {
	Route::get('/paypal/transaction-history', 'ApiAdminController@getTransaction');
});
Route::group(['middleware' => ['auth.student']], function () {
	Route::post('subscription/validation/apple' , 'ApiController@appleValidateSubscription');
});

Route::any('pay-pal/ipn' , 'PaypalController@InstantPaymentNotification');
Route::post('subscription/profile' , 'ApiController@appleGetStudentIdByReceipt');

Route::group(['prefix' => 'braintree' , 'middleware' => 'auth.user'], function(){
// Route::group(['prefix' => 'braintree'], function(){
	Route::post('/customer' , 'BraintreeController@createCustomer');
	Route::get('/customer' , 'BraintreeController@getCustomer');

	Route::get('/client-token' , 'BraintreeController@generateToken');
	Route::post('/subscribe' , 'BraintreeController@braintreeSubscribe');
});

