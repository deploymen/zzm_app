@section('menu')

<aside class="left-off-canvas-menu">
    <div class="logo">
        <img src="/assets/img/global/logo-icon.png" alt=" ">
    </div>
    <ul class="off-canvas-list">
        <li>
            <label>Zap Zap Math Admin Site</label>
        </li>
        <li>
            <a href="/admin/home">
                <i class="fa fa-tachometer"></i>
                Admin Dashboard
            </a>
        </li>
        <li>
            <a href="/admin/admin-account">
                 <i class="fa fa-user"></i>
                My Account Settings
            </a>
        </li>
        <li>
            <a href="/admin/admin-change-password">
                <i class="fa fa-key"></i>
                Change Password
            </a>
        </li>
        <li>
            <a href="/admin/reports">
                <i class="fa fa-line-chart"></i>
                Reports &amp; Analytics
            </a>
        </li>
    </ul>
</aside>

@stop