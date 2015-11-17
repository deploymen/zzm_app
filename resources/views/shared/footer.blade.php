<footer class="clearfix">
    <div class="row">
        <div class="copyright small-12 medium-12 large-8 columns">
            <p>Copyright &copy; <?php echo date('Y'); ?> Visual Math Interactive. All rights reserved. <a href="/terms">Terms of Use</a>. <a href="/privacy">Privacy Policy</a>.</p>
        </div>

        <div class="nav-footer small-12 medium-12 large-4 columns">
            <p>
                <a href="/">Home</a> |
                <a href="{{ config('zzm.blog_url') }}" onclick="ga('send', 'event', 'Footer Menu', 'Blog', 'Blog - Footer', {nonInteraction: true})">Blog</a> |
                <a href="/contributors" onclick="ga('send', 'event', 'Footer Menu', 'Contributor', 'Contributor - Footer', {nonInteraction: true})">Contributors</a> |
                <a href="/jobs" onclick="ga('send', 'event', 'Footer Menu', 'Job', 'Job - Footer', {nonInteraction: true})">Jobs</a>
            </p>
        </div>
    </div>
</footer>