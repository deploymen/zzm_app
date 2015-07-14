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
				<form data-abide="ajax" id="signup-form" class="signup-form" action="?action=signup" method="POST" novalidate="novalidate">
				  <fieldset>
				    <legend>Create A Free Zap Zap Math Account</legend>

				    <div class="row">
						<div class="small-6 columns">
							<label for="radio-parent" class="">
								<input name="role" type="radio" id="radio-parent" required="" value="parent"> I am a parent
							</label>
						</div>

						<div class="small-6 columns">
							<label for="radio-teacher" class="">
								<input name="role" type="radio" id="radio-teacher" required="" value="teacher"> I am a teacher
							</label>
						</div>
						<small class="error">Please select a role</small>
					</div>

				    <div class="row">
				      <div class="small-12 columns">
				        <label for="name">
				          <input type="text" id="users_name" placeholder="Hello! What's your name?" name="users_name" required pattern="[a-zA-Z]+">
				        </label>
				        <small class="error">Please fill in your name, we like to address our friends properly!</small>
				      </div>
				    </div>

				    <div class="row">
				      <div class="small-12 columns">
				        <label for="email">
				          <input type="email" id="users_email" placeholder="Please input your email address." name="password" required>
				        </label>
				        <small class="error">Please input a valid email address. Like example@domain.com</small>
				      </div>
				    </div>

				    <div class="row">
				      <div class="small-12 columns">
				        <label for="password">
				          <input type="password" id="users_password" placeholder="Please choose a secure password." name="password" required>
				        </label>
				        <small class="error">Passwords must be at least 8 characters with 1 capital letter, 1 number, and one special character.</small>
				      </div>
				    </div>

				    <div class="row">
				      <div class="small-12 columns">
				        <label for="country">
				          <input type="text" id="users_country" placeholder="What country do you call home?" name="country" required>
				        </label>
				        <small class="error">Please specify a country</small>
				      </div>
				    </div>

				    <div class="row">
				      <div class="small-12 columns">
				        <button type="submit" class="medium button green">Sign Up</button>
				      </div>
				    </div>

				  </fieldset>
				</form>
				<hr>
				<section class="prompt-login-wrapper">
					<h2>Already a member?</h2>
					<a href="#">Log in to Zap Zap Math!</a>
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
