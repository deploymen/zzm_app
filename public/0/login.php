<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Zap Zap Math | Login</title>
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
        <script src="js/modernizr/modernizr.min.js"></script>

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <link rel="icon" href="favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="../css/app.css">
    </head>
    <body>
        <!--[if IE 8]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
		
		<div class="site-wrapper">
			<section class="signup-holder">
				<div class="logo">
					<img src="../assets/img/global/logo-icon.png" alt=" ">
				</div>
				<form data-abide="ajax" id="login-form" method="POST" action="?action=login" novalidate="novalidate">
				  <fieldset>
				    <legend>Member Login</legend>

				    <div class="row">
				      <div class="small-12 columns">
				        <label for="email">
				          <input type="email" id="users_login_email" placeholder="What is your email address?" name="password" required>
				        </label>
				        <small class="error">Please input a valid email address. Like example@domain.com</small>
				      </div>
				    </div>

				    <div class="row">
				      <div class="small-12 columns">
				        <label for="password">
				          <input type="password" id="users_login_password" placeholder="What is your password?" name="password" required>
				        </label>
				        <small class="error">Please input your password</small>
				      </div>
				    </div>

				    <div class="row">
				      <div class="small-12 columns">
				        <a href="#">I forgot my password</a>
				      </div>
				    </div>

				    <div class="row">
				      <div class="small-12 columns">
				        <button type="submit" class="medium button green">Login</button>
				      </div>
				    </div>

				  </fieldset>
				</form>
				<hr>
				<section class="prompt-login-wrapper">
					<h2>Not a member yet?</h2>
					<a href="#">Register for free!</a>
				</section>
			</section><!--entry-wrapper-->
		</div><!--site-wrapper-->

        <!-- SCRIPTS START HERE -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/jquery/dist/jquery.min.js"><\/script>')</script>

        <script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/1.16.0/TweenMax.min.js"></script>

        <script src="../js/app.js"></script>

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
