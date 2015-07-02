@section('header')  

<header class="main-header">
    <nav class="tab-bar">
        <section class="left-small">
            <a class="left-off-canvas-toggle menu-icon" href="#">
                <span></span>
            </a>
        </section>

        <!-- <section class="middle tab-bar-section">
            <h1 class="title">Zap Zap Math Dashboard</h1>
        </section> -->

        <section class="profile-button right tab-bar-section">
            <button href="#" data-dropdown="drop-profile" aria-controls="drop-profile" aria-expanded="false" class="button dropdown">
                <span class="main-profile-picture">
                    <i class="fa fa-user"></i>
                </span>
                <span class="main-profile-name">
                    <p>{{\Request::input('user_name')}}</p>
                </span>
            </button><br>
            <ul id="drop-profile" data-dropdown-content class="drop-profile f-dropdown" aria-hidden="true">
                <li>
                    <a href="/user/account">
                        <i class="fa fa-user"></i>
                        My Account
                    </a>
                </li>
                <!-- <li><a href="#" id="button-logout" class="button-logout">Log Out</a></li> -->
            </ul>
        </section>
    </nav>
    @yield('breadcrumb')
    <!-- <nav class="breadcrumbs" role="menubar" aria-label="breadcrumbs">
        <li role="menuitem">
            <a href="#">Level 1</a>
        </li>
        <li role="menuitem">
            <a href="#">Level 2</a>
        </li>
        <li role="menuitem" class="unavailable" role="button" aria-disabled="true">
            <a href="#">Level 3</a>
        </li>
        <li role="menuitem" class="current">
            <a href="#">Level 4</a>
        </li>
    </nav> -->
    <!--breadcrumbs-->
</header><!--main-header-->

<section class="page-content-wrapper">
    <div class="row">
        <div class="small-12 columns">

@stop