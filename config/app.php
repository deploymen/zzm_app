<?php

return [

    'auth_salt' => env('AUTH_SALT'),
    'p02_key' => env('P02_KEY'),
    'sandbox' => env('SANDBOX'),
    'ses_key' => env('AWS_SES_KEY'),
    'ses_secret' => env('AWS_SES_SECRET'),
    'app_store_url' => env('APP_STORE_URL'),
    'website_url' => env('WEBSITE_URL'),
    'fanpage_url' => env('FANPAGE_URL'),
    'support_email' => env('SUPPORT_EMAIL'),
    'server_test' => env('SERVER'),
    'paid' => env('PAID'),
    'teacher_profile_limit' => env('TEACHER_PROFILE_LIMIT'),
    'teacher_class_limit' => env('TEACHER_CLASS_LIMIT'),
    'parent_profile_limit' => env('PARENT_PROFILE_LIMIT'),
    'send_in_blue_list_id' => env('LIST_ID'),
    'send_in_blue_parent_list_id' => env('SEND_IN_BLUE_PARENT_LIST_ID'),
    'send_in_blue_teacher_list_id' => env('SEND_IN_BLUE_TEACHER_LIST_ID'),
    'braintree_merchant_id' => env('BRAINTREE_MERCHANT_ID'),
    'braintree_public_key' => env('BRAINTREE_PUBLIC_KEY'),
    'braintree_private_key' => env('BRAINTREE_PRIVATE_KEY'),
    'braintree_sandbox' => env('BRAINTREE_SANDBOX'),
    'zzm_server' => env('ZZM_SERVER'),

    'google_api_service_id' => env('GOOGLE_SERVICE_ID'),
    'google_api_service_key' => env('GOOGLE_SERVICE_KEY'),
    'google_api_secret' => env('GOOGLE_SERVICE_ACCESS_PASSWORD'),

    /*
      |--------------------------------------------------------------------------
      | Application Debug Mode
      |--------------------------------------------------------------------------
      |
      | When your application is in debug mode, detailed error messages with
      | stack traces will be shown on every error that occurs within your
      | application. If disabled, a simple generic error page is shown.
      |
     */
    'debug' => env('APP_DEBUG'),
    /*
      |--------------------------------------------------------------------------
      | Application URL
      |--------------------------------------------------------------------------
      |
      | This URL is used by the console to properly generate URLs when using
      | the Artisan command line tool. You should set this to the root of
      | your application so that it is used when running Artisan tasks.
      |
     */
    'url' => env('URL'),
    /*
      |--------------------------------------------------------------------------
      | Application Timezone
      |--------------------------------------------------------------------------
      |
      | Here you may specify the default timezone for your application, which
      | will be used by the PHP date and date-time functions. We have gone
      | ahead and set this to a sensible default for you out of the box.
      |
     */
    'timezone' => 'Asia/Kuala_Lumpur',
    /*
      |--------------------------------------------------------------------------
      | Application Locale Configuration
      |--------------------------------------------------------------------------
      |
      | The application locale determines the default locale that will be used
      | by the translation service provider. You are free to set this value
      | to any of the locales which will be supported by the application.
      |
     */
    'locale' => 'en',
    /*
      |--------------------------------------------------------------------------
      | Application Fallback Locale
      |--------------------------------------------------------------------------
      |
      | The fallback locale determines the locale to use when the current one
      | is not available. You may change the value to correspond to any of
      | the language folders that are provided through your application.
      |
     */
    'fallback_locale' => 'en',
    /*
      |--------------------------------------------------------------------------
      | Encryption Key
      |--------------------------------------------------------------------------
      |
      | This key is used by the Illuminate encrypter service and should be set
      | to a random, 32 character string, otherwise these encrypted strings
      | will not be safe. Please do this before deploying an application!
      |
     */
    'key' => env('APP_KEY', 'SoanmdriomSteRng'),
    'cipher' => MCRYPT_RIJNDAEL_128,
    /*
      |--------------------------------------------------------------------------
      | Logging Configuration
      |--------------------------------------------------------------------------
      |
      | Here you may configure the log settings for your application. Out of
      | the box, Laravel uses the Monolog PHP logging library. This gives
      | you a variety of powerful log handlers / formatters to utilize.
      |
      | Available Settings: "single", "daily", "syslog", "errorlog"
      |
     */
    'log' => 'daily',
    /*
      |--------------------------------------------------------------------------
      | Autoloaded Service Providers
      |--------------------------------------------------------------------------
      |
      | The service providers listed here will be automatically loaded on the
      | request to your application. Feel free to add your own services to
      | this array to grant expanded functionality to your applications.
      |
     */
    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        'Illuminate\Foundation\Providers\ArtisanServiceProvider',
        'Illuminate\Auth\AuthServiceProvider',
        'Illuminate\Bus\BusServiceProvider',
        'Illuminate\Cache\CacheServiceProvider',
        'Illuminate\Foundation\Providers\ConsoleSupportServiceProvider',
        'Illuminate\Routing\ControllerServiceProvider',
        'Illuminate\Cookie\CookieServiceProvider',
        'Illuminate\Database\DatabaseServiceProvider',
        'Illuminate\Encryption\EncryptionServiceProvider',
        'Illuminate\Filesystem\FilesystemServiceProvider',
        'Illuminate\Foundation\Providers\FoundationServiceProvider',
        'Illuminate\Hashing\HashServiceProvider',
        'Illuminate\Mail\MailServiceProvider',
        'Illuminate\Pagination\PaginationServiceProvider',
        'Illuminate\Pipeline\PipelineServiceProvider',
        'Illuminate\Queue\QueueServiceProvider',
        'Illuminate\Redis\RedisServiceProvider',
        'Illuminate\Auth\Passwords\PasswordResetServiceProvider',
        'Illuminate\Session\SessionServiceProvider',
        'Illuminate\Translation\TranslationServiceProvider',
        'Illuminate\Validation\ValidationServiceProvider',
        'Illuminate\View\ViewServiceProvider',
        /*
         * Application Service Providers...
         */
        'App\Providers\AppServiceProvider',
        'App\Providers\BusServiceProvider',
        'App\Providers\ConfigServiceProvider',
        'App\Providers\EventServiceProvider',
        'App\Providers\RouteServiceProvider',
        'Chumper\Zipper\ZipperServiceProvider',
        'Laravel\Socialite\SocialiteServiceProvider',
        'GrahamCampbell\Throttle\ThrottleServiceProvider',
        'Avanderbergh\Schoology\Saml2ServiceProvider',
        'Avanderbergh\Schoology\SchoologyServiceProvider',
    ],
    /*
      |--------------------------------------------------------------------------
      | Class Aliases
      |--------------------------------------------------------------------------
      |
      | This array of class aliases will be registered when this application
      | is started. However, feel free to register as many as you wish as
      | the aliases are "lazy" loaded so they don't hinder performance.
      |
     */
    'aliases' => [

        'App' => 'Illuminate\Support\Facades\App',
        'Artisan' => 'Illuminate\Support\Facades\Artisan',
        'Auth' => 'Illuminate\Support\Facades\Auth',
        'Blade' => 'Illuminate\Support\Facades\Blade',
        'Bus' => 'Illuminate\Support\Facades\Bus',
        'Cache' => 'Illuminate\Support\Facades\Cache',
        'Config' => 'Illuminate\Support\Facades\Config',
        'Cookie' => 'Illuminate\Support\Facades\Cookie',
        'Crypt' => 'Illuminate\Support\Facades\Crypt',
        'DB' => 'Illuminate\Support\Facades\DB',
        'Eloquent' => 'Illuminate\Database\Eloquent\Model',
        'Event' => 'Illuminate\Support\Facades\Event',
        'File' => 'Illuminate\Support\Facades\File',
        'Hash' => 'Illuminate\Support\Facades\Hash',
        'Input' => 'Illuminate\Support\Facades\Input',
        'Inspiring' => 'Illuminate\Foundation\Inspiring',
        'Lang' => 'Illuminate\Support\Facades\Lang',
        'Log' => 'Illuminate\Support\Facades\Log',
        'Mail' => 'Illuminate\Support\Facades\Mail',
        'Password' => 'Illuminate\Support\Facades\Password',
        'Queue' => 'Illuminate\Support\Facades\Queue',
        'Redirect' => 'Illuminate\Support\Facades\Redirect',
        'Redis' => 'Illuminate\Support\Facades\Redis',
        'Request' => 'Illuminate\Support\Facades\Request',
        'Response' => 'Illuminate\Support\Facades\Response',
        'Route' => 'Illuminate\Support\Facades\Route',
        'Schema' => 'Illuminate\Support\Facades\Schema',
        'Session' => 'Illuminate\Support\Facades\Session',
        'Storage' => 'Illuminate\Support\Facades\Storage',
        'URL' => 'Illuminate\Support\Facades\URL',
        'Validator' => 'Illuminate\Support\Facades\Validator',
        'View' => 'Illuminate\Support\Facades\View',
        'Zipper' => 'Chumper\Zipper\Zipper',
        'Socialite' => 'Laravel\Socialite\Facades\Socialite',
        'Throttle' => 'GrahamCampbell\Throttle\Facades\Throttle',
        'Schoology' => 'Avanderbergh\Schoology\Facades\Schoology'
    ],
];
