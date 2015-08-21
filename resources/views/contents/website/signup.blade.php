<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Zap Zap Math | Sign Up</title>
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
        <link rel="icon" href="favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="/css/main/app.css">
    </head>
    <body ng-app="signupApp" ng-controller="SignupController">
        <!--[if IE 8]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        
        <div class="site-wrapper sign-in-up">
            <div class="row">
                <section id="signup-holder" class="signup-holder cf">
                    <section class="signup-holder-inner small-12 medium-4 medium-centered columns">
                        <div class="logo">
                            <img src="/assets/main/img/global/logo-main-white.png" alt=" ">
                        </div>
                        <form name="signup_form" id="signup-form" class="signup-form" novalidate ng-submit="signupForm()">
                            <div class="row">
                                <div class="small-6 columns">
                                    <label for="radio-parent" class="">
                                        <input name="role" type="radio" id="radio-parent" ng-model="role" required="!role" value="parent" ng-focus> I am a parent
                                    </label>
                                </div>

                                <div class="small-6 columns">
                                    <label for="radio-teacher" class="">
                                        <input name="role" type="radio" id="radio-teacher" ng-model="role" required="!role" value="teacher"> I am a teacher
                                    </label>
                                </div>
                                <div class="error-container" 
                                     ng-show="signup_form.role.$dirty && signup_form.role.$invalid && signup_form.submitted">
                                  <small class="error" 
                                         ng-show="signup_form.role.$error.required">
                                         Please specify a role.
                                  </small>
                                </div>
                            </div>

                            <div class="row">
                              <div class="small-12 columns">
                                <label for="users-name" class="label-header">
                                Name
                                  <input type="text" id="users-name" placeholder="John Jones" name="name" required ng-model="name" ng-minlength=3>
                                </label>
                                <div class="error-container" 
                                    ng-show="signup_form.uname.$dirty && signup_form.uname.$invalid && signup_form.submitted">
                                <small class="error" 
                                    ng-show="signup_form.uname.$error.required">
                                    Your name is required.
                                </small>
                                <small class="error" 
                                        ng-show="signup_form.uname.$error.minlength">
                                        Your name is required to be at least 3 characters
                                </small>
                              </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="small-12 columns">
                                <label for="users_email" class="label-header">
                                    Email
                                  <input type="email" id="users_email" placeholder="johnjones@internet.com" name="email" required ng-model="email">
                                </label>
                                <div class="error-container" 
                                     ng-show="signup_form.email.$dirty && signup_form.email.$invalid && signup_form.submitted">
                                  <small class="error" 
                                         ng-show="signup_form.email.$error.required">
                                         Your email is required.
                                  </small>
                                  <small class="error" 
                                         ng-show="signup_form.email.$error.email">
                                         That is not a valid email. Please input a valid email.
                                  </small>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="small-12 columns">
                                <label for="users_password" class="label-header">
                                Password
                                  <input type="password" id="users_password" placeholder="......" name="users_password" ng-model="password" required ng-minlength=6>
                                </label>
                                <div class="error-container" 
                                     ng-show="signup_form.users_password.$dirty && signup_form.users_password.$invalid && signup_form.submitted">
                                  <small class="error" 
                                         ng-show="signup_form.users_password.$error.required">
                                         You need to have a password.
                                  </small>
                                  <small class="error" 
                                         ng-show="signup_form.users_password.$error.minlength">
                                         Your password needs to be at least 6 characters long.
                                  </small>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="small-12 columns">
                                <label for="users_country" class="label-header">
                                Country
                                  <select id="users_country" name="country" required ng-model="country" ng-options="country.name for country in countries track by country.code">
                                    <option value="">-- Select a Country --</option>
                                  </select>
                                </label>
                                <div class="error-container" 
                                     ng-show="signup_form.country.$dirty && signup_form.country.$invalid && signup_form.submitted">
                                  <small class="error" 
                                         ng-show="signup_form.country.$error.required">
                                         Please choose your country from the list.
                                  </small>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="small-12 columns">
                                <button data-ng-disabled="progress.active()" data-ng-click="submit(signup_form)" class="medium radius button expand blue">Submit</button>
                                <!-- <button type="submit" ng-disabled="signup_form.$invalid" class="button radius blue">Submit</button> -->
                                <!-- <button id="btn-signup" type="submit" ng-disabled="signup_form.$invalid" class="medium radius button expand blue">Sign me up!</button> -->
                              </div>
                            </div>
                        </form>
                        <hr>
                        <section class="prompt-login-wrapper">
                            <h6>Already have an account? <a href="/user/signin">Sign In!</a></h6> 
                        </section>
                    </section><!--signup-holder-inner-->
                </section>
            </div>
            <div class="blue-bg-overlay"></div>
        </div><!--site-wrapper-->

        <!-- SCRIPTS START HERE -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/jquery/dist/jquery.min.js"><\/script>')</script>

        <script src="/js/main/app.js"></script>
        <script src="/js/main/init.js"></script>
        <script src="/js/main/angular-promise-tracker/promise-tracker.js"></script>
        <script src="/js/main/signup.js"></script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
          // (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          // (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          // m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          // })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
          // ga('create', 'UA-60608433-1', 'auto');
          // ga('send', 'pageview');
        // </script>
    </body>
</html>
