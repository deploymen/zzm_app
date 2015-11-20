<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Zap Zap Math | Set Password</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Open Graph Tags -->
        <meta property="og:title" content=" " />
        <meta property="og:description" content=" " />
        <meta property="og:url" content=" " />
        <meta property="og:site_name" content="Zap Zap Math" />
        <meta property="og:image" content=" " />
        <link rel="canonical" href=" " />

        <!-- Twitter Sharing Tags -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@vmathstudio">
        <meta name="twitter:creator" content="@vmathstudio">
        <meta name="twitter:title" content=" ">
        <meta name="twitter:description" content=" ">
        <meta name="twitter:image:src" content=" ">

        <script type="text/javascript" src="//use.typekit.net/sfk0apd.js"></script>
        <script type="text/javascript">try{Typekit.load();}catch(e){}</script>
        <script src="/js/modernizr/modernizr.min.js"></script>

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="/css/main/app.css">
    </head>
    <body>
        <!--[if IE 8]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        
        <div class="site-wrapper sign-in-up">

            <div class="row">
                <section class="signup-holder cf">
                    <section class="signup-holder-inner small-12 medium-4 medium-centered columns">
                        <div class="logo">
                            <img src="/assets/main/img/global/logo-main-white.png" alt=" ">
                        </div>
                        <form data-abide="ajax" id="reset-password-form" class="login-form" novalidate="novalidate">
                            <div class="row">
                                <div class="small-12 columns">
                                <label for="password" class="label-header">Password <small>required</small>
                                    <input type="password" id="password" placeholder="........" name="password" required pattern=".{6,}">
                                </label>
                                <small class="error">Passwords must be at least 6</small>
                                </div>
                            </div>

                            <div class="row">
                                <div class="small-12 columns">
                                <label for="confirmPassword" class="label-header" role="alert">Confirm Password <small>required</small>
                                <input type="password" id="confirmResetPassword" placeholder="........" name="confirmPassword" required="" data-equalto="password">
                                </label>
                                <small class="error">Passwords must match.</small>
                                </div>
                            </div>

                            <div class="row">
                              <div class="small-12 columns">
                                <a id="btn-reset-password" class="medium button expand radius blue">Set Password</a>
                              </div>
                            </div>
                        </form>
                    </section><!--signup-holder-inner-->
                    <div class="forgot-password-box small-12 medium-4 medium-centered columns">
                        <a href="/user/signin">back</a>
                    </div>
                </section>       
            </div>

            <div id="resetsuccess" class="reveal-modal text-center" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
                <h3 id="modalTitle">Hooray</h3>
                <p class="lead">Your password has been reset. Please login using your new password.</p>
                <div class="row">
                    <div class="medium-5 box-centered text-center">
                        <label>
                            <input type="button" value="OK" id="btn-reset-ok" class="button wide radius blue" />
                        </label>
                    </div>
                </div>
                <a href="javascript:void(0)" class="close-reveal-modal" aria-label="Close">OK</a>
            </div>

            <div class="blue-bg-overlay"></div>



        </div><!--site-wrapper-->

        <!-- SCRIPTS START HERE -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/jquery/dist/jquery.min.js"><\/script>')</script>

        <script src="/js/main/app.js"></script>
        <script src="/js/main/reset-password.js"></script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
          // (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          // (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          // m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          // })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
          // ga('create', 'UA-60608433-1', 'auto');
          // ga('send', 'pageview');
        </script>
    </body>
</html>
