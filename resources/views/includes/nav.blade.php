<header class="">
    <div class="top-bar">
        <div class="top-bar-left column row">
            <ul class="dropdown menu" data-dropdown-menu>
                <li {!! \Request::route()->getUri() == 'docs/index' ? 'class="active"' : '' !!}>
                    <a id="logo" href="/api/docs/index">
                        <span class="fa fa-rocket"></span>
                        <span>API DOC</span>
                    </a>
                </li>
                <li {!! $sidebar_item == 'list-general' ? 'class="active"' : '' !!}>
                    <a href="/api/docs/list-general">
                        <i class="fa fa-list fa-fw"></i>
                        <span>AUTH API</span>
                    </a>
                </li>
                <li {!! $sidebar_item == 'list-user' ? 'class="active"' : '' !!}>
                    <a href="/api/docs/list-user">
                        <i class="fa fa-user fa-fw"></i>
                        <span>USER API</span>
                    </a>
                </li>
                <li {!! $sidebar_item == 'list-admin' ? 'class="active"' : '' !!}>
                    <a href="/api/docs/list-admin">
                        <i class="fa fa-desktop fa-fw"></i>
                        <span>ADMIN API</span>
                    </a>
                </li>
                <li {!! $sidebar_item == 'list-game' ? 'class="active"' : '' !!}>
                    <a href="/api/docs/list-game">
                        <i class="fa fa-gamepad fa-fw"></i>
                        <span>GAME API</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>