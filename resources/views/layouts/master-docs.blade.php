<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Zap Zap Math | API Documentation</title>
        <meta charset="utf-8"> 
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!--CSS-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/foundation/6.2.3/foundation.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prettify/r298/prettify.min.css"/>
        <link rel="stylesheet" href="/api/css/app.css"/>
        @yield('css_include')
    </head>
    <body onload="prettyPrint()">

        <!--Menu-->
        @include('includes/nav')

        <!--Content-->
        <div class="column row">
            @yield('content')
        </div>

        <!--Footer-->
        @include('includes/footer')

        <!--JS-->
        <script src="https://use.fontawesome.com/7b5c2ede6e.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/foundation/6.2.3/foundation.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/prettify/r298/prettify.min.js"></script>
        <script src="/api/js/app.js"></script>
        @yield('js_include')
    </body>
</html>