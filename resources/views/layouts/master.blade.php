<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Zap Zap Math | @yield('title')</title>
        <meta name="description" content="@yield('description')">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @yield('extra_meta')

        <!-- Open Graph Tags -->
        <meta property="og:title" content="@yield('title')" />
        <meta property="og:description" content="@yield('description')" />
        <meta property="og:url" content="{!! Request::url() !!}" />
        <meta property="og:site_name" content="Zap Zap Math" />
        <meta property="og:image" content="{{ config('zzm.cdn_static') }}/images/global/zzm-social-image.jpg" />
        <link rel="canonical" href="{!! Request::url() !!}" />

        <!-- Twitter Sharing Tags -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="{{ '@' . config('zzm.twitter_username') }}">
        <meta name="twitter:creator" content="{{ '@' . config('zzm.twitter_username') }}">
        <meta name="twitter:title" content="@yield('title')">
        <meta name="twitter:description" content="@yield('description')">
        <meta name="twitter:image:src" content="{{ config('zzm.cdn_static') }}/images/global/zzm-twimage.jpg">

        <!-- Favicons -->
        <link rel="apple-touch-icon" sizes="57x57" href="{{ config('zzm.cdn_static') }}/favicons/apple-touch-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ config('zzm.cdn_static') }}/favicons/apple-touch-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ config('zzm.cdn_static') }}/favicons/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ config('zzm.cdn_static') }}/favicons/apple-touch-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ config('zzm.cdn_static') }}/favicons/apple-touch-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ config('zzm.cdn_static') }}/favicons/apple-touch-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ config('zzm.cdn_static') }}/favicons/apple-touch-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ config('zzm.cdn_static') }}/favicons/apple-touch-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ config('zzm.cdn_static') }}/favicons/apple-touch-icon-180x180.png">
        <link rel="icon" type="image/png" href="{{ config('zzm.cdn_static') }}/favicons/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="{{ config('zzm.cdn_static') }}/favicons/android-chrome-192x192.png" sizes="192x192">
        <link rel="icon" type="image/png" href="{{ config('zzm.cdn_static') }}/favicons/favicon-96x96.png" sizes="96x96">
        <link rel="icon" type="image/png" href="{{ config('zzm.cdn_static') }}/favicons/favicon-16x16.png" sizes="16x16">
        <link rel="manifest" href="{{ config('zzm.cdn_static') }}/favicons/manifest.json">
        <meta name="msapplication-TileColor" content="#2b5797">
        <meta name="msapplication-TileImage" content="{{ config('zzm.cdn_static') }}/favicons/mstile-144x144.png">
        <meta name="theme-color" content="#ffffff">

        <!-- Load Modernizr first -->
        <script src="/js/modernizr-2.8.3.min.js"></script>

        <!-- Stylesheets - internal -->
        <link rel="stylesheet" href="{{ elixir('css/all.css') }}">
        <link rel="stylesheet" href="{{ elixir('css/app.css') }}">

        <!-- Stylesheets - additional -->
        @yield('extra_style')

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        
        <!-- Typekit -->
        <script src="https://use.typekit.net/{{ config('zzm.typekit_code') }}.js"></script>
        <script>try {
    Typekit.load({async: true});
} catch (e) {
}</script>
    </head>
    <body>
        <!--[if IE 8]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        @yield('body')

        <a id="btn-to-top" class="btn-to-top" href="javascript:void(0);"><i class="fa fa-chevron-up"></i></a>

        <!-- Jquery with fallback -->
        @if(env('APP_DEBUG') == 1)
        <script src="//code.jquery.com/jquery-1.11.3.js"></script>
        @else
        <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
        @endif
        <script>window.jQuery || document.write('<script src="/js/jquery-1.11.3.min.js"><\/script>')</script>

        <!--Combined scripts-->
        <script src="{{ elixir('js/all.js') }}"></script>

        <!--Extra scripts-->
        @yield('extra_scripts')

        <!--Google Analytics-->
        @if (config('zzm.google_analytics_id'))

        <script>
(function (i, s, o, g, r, a, m) {
    i['GoogleAnalyticsObject'] = r;
    i[r] = i[r] || function () {
        (i[r].q = i[r].q || []).push(arguments)
    }, i[r].l = 1 * new Date();
    a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
    a.async = 1;
    a.src = g;
    m.parentNode.insertBefore(a, m)
})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

ga('create', '{{ config('zzm.google_analytics_id') }}', 'auto');
ga('send', 'pageview');
        </script>
        @else
        <!--Google Analytics could not be loaded-->
        @endif

    </body>
</html>
