<!DOCTYPE html>
<html lang="en">
<head><title>Zap Zap Math | API Documentation</title>
    <meta charset="utf-8"> 
  <link rel="stylesheet" href="highlighter/prettify.css"/>
    <link rel="stylesheet" href="highlighter/prettify.css"/>
    <script src="highlighter/prettify.js"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="Thu, 19 Nov 1900 08:52:00 GMT">
    <link rel="shortcut icon" href="images/icons/favicon.ico">
    <link rel="apple-touch-icon" href="images/icons/favicon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/icons/favicon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/icons/favicon-114x114.png">
    <!--Loading bootstrap css-->
    <link type="text/css" rel="stylesheet"
          href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,700">
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,700,300">
    <link type="text/css" rel="stylesheet"
          href="vendors/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.min.css">
    <link type="text/css" rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="vendors/bootstrap/css/bootstrap.min.css">
    <!--LOADING STYLESHEET FOR PAGE-->
    <link type="text/css" rel="stylesheet" href="vendors/intro.js/introjs.css">
    <link type="text/css" rel="stylesheet" href="vendors/calendar/zabuto_calendar.min.css">
    <link type="text/css" rel="stylesheet" href="vendors/sco.message/sco.message.css">
    <link type="text/css" rel="stylesheet" href="vendors/intro.js/introjs.css">
    <!--Loading style vendors-->
    <link type="text/css" rel="stylesheet" href="vendors/animate.css/animate.css">
    <link type="text/css" rel="stylesheet" href="vendors/jquery-pace/pace.css">
    <link type="text/css" rel="stylesheet" href="vendors/iCheck/skins/all.css">
    <link type="text/css" rel="stylesheet" href="vendors/jquery-notific8/jquery.notific8.min.css">
    <link type="text/css" rel="stylesheet" href="vendors/bootstrap-daterangepicker/daterangepicker-bs3.css">
    <!--Loading style-->
    <link type="text/css" rel="stylesheet" href="css/themes/style1/orange-blue.css" class="default-style">
    <link type="text/css" rel="stylesheet" href="css/themes/style1/orange-blue.css" id="theme-change"
          class="style-change color-change">
    <link type="text/css" rel="stylesheet" href="css/style-responsive.css">
    @yield('css_include')
</head>
<body class=" ">
<div>
    <!--BEGIN BACK TO TOP--><a id="totop" href="#"><i class="fa fa-angle-up"></i></a><!--END BACK TO TOP-->
    
    <!--BEGIN TOPBAR-->
    <div id="header-topbar-option-demo" class="page-header-topbar">
        <nav id="topbar" role="navigation" style="margin-bottom: 0; z-index: 2;"
             class="navbar navbar-default navbar-static-top">
            <div class="navbar-header">
                <button type="button" data-toggle="collapse" data-target=".sidebar-collapse" class="navbar-toggle"><span
                        class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span
                        class="icon-bar"></span><span class="icon-bar"></span></button>
                <a id="logo" href="api/docs/index" class="navbar-brand"><span class="fa fa-rocket"></span><span
                        class="logo-text">API DOC</span><span style="display: none" class="logo-text-icon">µ</span></a>
            </div>
            <div class="topbar-main"><a id="menu-toggle" href="#" class="hidden-xs"><i class="fa fa-bars"></i></a>
            </div>
        </nav>
    </div>
    <!--END TOPBAR-->

    <div id="wrapper">
    <!--BEGIN SIDEBAR MENU-->
        <nav id="sidebar" role="navigation" class="navbar-default navbar-static-side">
            <div class="sidebar-collapse menu-scroll">
                <ul id="side-menu" class="nav">
                    <div class="clearfix"></div>
                    @if ($sidebar_item === 'list-general')
                        <li class="active"><a href="/api/docs/list-general"><i class="fa fa-list fa-fw">
                            <div class="icon-bg bg-orange"></div>
                        </i><span class="menu-title">AUTH API</span></a></li>
                    @else
                        <li><a href="/api/docs/list-general"><i class="fa fa-list fa-fw">
                            <div class="icon-bg bg-orange"></div>
                        </i><span class="menu-title">AUTH API</span></a></li>
                    @endif 
                    @if ($sidebar_item === 'list-user')
                        <li class="active"><a href="/api/docs/list-user"><i class="fa fa-user fa-fw">
                            <div class="icon-bg bg-orange"></div>
                        </i><span class="menu-title">USER API</span></a></li>
                    @else
                        <li><a href="/api/docs/list-user"><i class="fa fa-user fa-fw">
                            <div class="icon-bg bg-orange"></div>
                        </i><span class="menu-title">USER API</span></a></li>
                    @endif 
                    @if ($sidebar_item === 'list-admin')
                        <li class="active"><a href="/api/docs/list-admin"><i class="fa fa-desktop fa-fw">
                            <div class="icon-bg bg-orange"></div>
                        </i><span class="menu-title">ADMIN API</span></a></li>
                    @else
                        <li><a href="/api/docs/list-admin"><i class="fa fa-desktop fa-fw">
                            <div class="icon-bg bg-orange"></div>
                        </i><span class="menu-title">ADMIN API</span></a></li>
                    @endif 
                    @if ($sidebar_item === 'list-game')
                        <li class="active"><a href="/api/docs/list-game"><i class="fa fa-gamepad fa-fw">
                            <div class="icon-bg bg-orange"></div>
                        </i><span class="menu-title">GAME API</span></a></li>
                    @else
                        <li><a href="/api/docs/list-game"><i class="fa fa-gamepad fa-fw">
                            <div class="icon-bg bg-orange"></div>
                        </i><span class="menu-title">GAME API</span></a></li>
                    @endif 
                </ul>
            </div>
        </nav>
        <!--END SIDEBAR MENU-->

        <!--BEGIN PAGE WRAPPER-->
        <div id="page-wrapper">
            
            @yield('breadcrumb')

            <!--BEGIN CONTENT-->
            <div class="page-content">
                <div id="tab-general">

                    @yield('content')
                    
                </div>
            </div>
            <!--END CONTENT-->
        </div>
        <!--END PAGE WRAPPER-->

        <!--BEGIN FOOTER-->
        <div id="footer">
            <div class="copyright">2015 © ZapZapMath - Visual Math</div>
        </div>
        <!--END FOOTER-->
    </div>
    <!--END PAGE WRAPPER-->
</div>

<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/jquery-migrate-1.2.1.min.js"></script>
<script src="js/jquery-ui.js"></script>
<!--loading bootstrap js-->
<script src="vendors/bootstrap/js/bootstrap.min.js"></script>
<script src="vendors/bootstrap-hover-dropdown/bootstrap-hover-dropdown.js"></script>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<script src="vendors/metisMenu/jquery.metisMenu.js"></script>
<script src="vendors/slimScroll/jquery.slimscroll.js"></script>
<script src="vendors/jquery-cookie/jquery.cookie.js"></script>
<script src="vendors/iCheck/icheck.min.js"></script>
<script src="vendors/iCheck/custom.min.js"></script>
<script src="vendors/jquery-notific8/jquery.notific8.min.js"></script>
<script src="vendors/jquery-highcharts/highcharts.js"></script>
<script src="js/jquery.menu.js"></script>
<script src="vendors/holder/holder.js"></script>
<script src="vendors/responsive-tabs/responsive-tabs.js"></script>
<script src="vendors/jquery-news-ticker/jquery.newsTicker.min.js"></script>
<script src="vendors/moment/moment.js"></script>
<script src="vendors/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
<!--CORE JAVASCRIPT-->
<script src="js/main.js"></script>
@yield('js_include')
<!--LOADING SCRIPTS FOR PAGE-->
<script src="vendors/intro.js/intro.js"></script>
<script>
    prettyPrint();
</script>
<style>
.prettyprint {
  white-space: pre-wrap;
}
</style>

<script type="text/javascript">(function (i, s, o, g, r, a, m) {
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
ga('create', 'UA-145464-14', 'auto');
ga('send', 'pageview');


</script>
</body>
</html>