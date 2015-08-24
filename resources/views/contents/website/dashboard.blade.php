@extends('layouts.master')
@extends('components.main-header')
@extends('components.menu-user')
@extends('components.main-footer')

@section('css_include')
<style type="text/css">

</style>
@stop

@section('js_include')
<script type="text/javascript">
    
</script>
@stop

@section('content')            

		<div class="site-wrapper">
            <div class="off-canvas-wrap" data-offcanvas>
                <div class="inner-wrap">
                    <aside class="left-off-canvas-menu">
                        <ul class="off-canvas-list">
                            <li>
                                <label>Zap Zap Math Dashboard</label>
                            </li>
                            <li>
                                <a href="#">Member Dashboard</a>
                            </li>
                            <li>
                                <a href="#">My Account Settings</a>
                            </li>
                            <li>
                                <a href="#">Change Password</a>
                            </li>
                            <li>
                                <a href="#">Profiles</a>
                            </li>
                            <li>
                                <a href="#">Classes</a>
                            </li>
                            <li>
                                <a href="#">Reports &amp; Analytics</a>
                            </li>
                            <li>
                                <label>Quiz Options</label>
                            </li>
                            <li>
                                <a href="#">Create New Quiz</a>
                            </li>
                            <li>
                                <a href="#">View Quiz</a>
                            </li>
                        </ul>
                    </aside>

                    <section class="main-section">
                        <nav class="tab-bar">
                            <section class="left-small">
                                <a class="left-off-canvas-toggle menu-icon" href="#">
                                    <span></span>
                                </a>
                            </section>

                            <section class="middle tab-bar-section">
                                <h1 class="title">Zap Zap Math Dashboard</h1>
                            </section>

                            <section class="profile-button right tab-bar-section">
                                <button href="#" data-dropdown="drop-profile" aria-controls="drop-profile" aria-expanded="false" class="button dropdown">
                                    <span class="profile-picture">
                                        <img src="../assets/img/global/dummy-profile-pic.jpg" alt="">
                                    </span>
                                    <span class="profile-name">
                                        <p>Jeremy Franco Hor</p>
                                    </span>
                                </button><br>
                                <ul id="drop-profile" data-dropdown-content class="drop-profile f-dropdown" aria-hidden="true">
                                    <li><a href="#">My Account</a></li>
                                    <li><a href="#" id="button-logout" class="button-logout">Log Out</a></li>
                                </ul>
                            </section>
                        </nav>
                    </section><!--main-section-->

                    <footer class="main-site-footer">
                        <p class="copyright">
                            Copyright &copy; 2015 Visual Math Interactive
                        </p>
                    </footer><!--main-site-footer-->

                    <a class="exit-off-canvas"></a>
                </div><!--inner-wrap-->
            </div><!--off-canvas-wrap-->
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

@stop