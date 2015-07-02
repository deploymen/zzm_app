<?php namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

	/**
	 * The application's global HTTP middleware stack.
	 *
	 * @var array
	 */
	protected $middleware = [
		'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
		'Illuminate\Cookie\Middleware\EncryptCookies',
		'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
		'Illuminate\Session\Middleware\StartSession',
		'Illuminate\View\Middleware\ShareErrorsFromSession',
		//'App\Http\Middleware\VerifyCsrfToken',
	];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'auth.user' => 'App\Http\Middleware\AuthenticateUser',
		'auth.game' => 'App\Http\Middleware\AuthenticateGamePlay',
		'auth.parent' => 'App\Http\Middleware\AuthenticateParent',
		'auth.teacher' => 'App\Http\Middleware\AuthenticateTeacher',
		'auth.content' => 'App\Http\Middleware\AuthenticateContent',


	];

}
