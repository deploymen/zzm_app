@section('menu')
<aside class="left-off-canvas-menu">
    <ul>
        <li><label class="main-label">Dashboard</label></li>
        <li<?php echo ($sidebar_item == 'game_profiles') ? ' class="active"' : ''; ?>>
            <a href="/user/profiles"><i class="fa fa-star"></i>Game Profiles</a>
        </li>
        <li<?php echo ($sidebar_item == 'change_password') ? ' class="active"' : ''; ?>>
            <a href="/user/change-password"><i class="fa fa-key"></i>Change Password</a>
        </li>
        <li><a href="/user/signout"><i class="fa fa-sign-out"></i>Logout</a></li>
    </ul>
</aside>
@stop