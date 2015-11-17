<nav class="menu clearfix">
    <div class="row">
        <div class="show-for-large-up large-3 columns">
            <a class="home-link" href="/" onclick="ga('send', 'event', 'Top Menu', 'Home', 'Home - Top Menu', {nonInteraction: true})"></a>
        </div>

        <div id="menu-toggle"><i class="fa fa-bars"></i></div>

        <div class="small-12 medium-12 large-6 columns" id="toggled-menu">
            <ul class="links">
                <li class="hide-for-large-up"><a href="/">Home</a></li>
                <li class="hide-for-large-up show-for-medium-only divider">|</li>
                <li><a href="/contributors" onclick="ga('send', 'event', 'Top Menu', 'Contributor', 'Contributor - Top Menu', {nonInteraction: true})">Contributors</a></li>
                <li class="divider">|</li>
                <li><a href="{{ config('zzm.blog_url') }}" onclick="ga('send', 'event', 'Top Menu', 'Blog', 'Blog - Top Menu', {nonInteraction: true})">Blog</a></li>
                <li class="divider">|</li>
                <li><a href="/jobs" onclick="ga('send', 'event', 'Top Menu', 'Job', 'Job - Top Menu', {nonInteraction: true})">Jobs</a></li>
                @if (config('zzm.flag_signin'))
                <li class="signin-link"><a  class="btn-launch-orange" href="/user/signin" onclick="ga('send', 'event', 'Top Menu', 'Sign In', 'Sign In - Top Menu', {nonInteraction: true})">Sign in</a></li>
                @endif
            </ul>
        </div>

        <div class="show-for-large-up large-3 columns download-links">
            @if (config('zzm.app_store'))
            <a href="{{ config('zzm.app_store') }}" class="btn-gplaystore left"><img src="{{ config('zzm.cdn_static') }}/images/global/app-store.png" alt="" onclick="ga('send', 'event', 'Top Menu', 'App Store', 'App Store - Top Menu', {nonInteraction: true})"></a>
            @endif
            @if (config('zzm.play_store'))
            <a href="{{ config('zzm.play_store') }}" class="btn-gplaystore right"><img src="{{ config('zzm.cdn_static') }}/images/global/play-store.png" alt="" onclick="ga('send', 'event', 'Top Menu', 'Play Store', 'Play Store - Top Menu', {nonInteraction: true})"></a>
            @endif
        </div>
    </div>
</nav>