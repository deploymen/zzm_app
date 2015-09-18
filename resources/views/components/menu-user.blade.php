@section('menu')

<aside class="left-off-canvas-menu">
    <ul class="off-canvas-list">
        <li>
            <label class="main-label">
                Dashboard
            </label>
        </li>
        <li>
            <a href="/user/profiles">
                Member Dashboard
            </a>
        </li>
        <li>
            <a href="/user/account">
                My Account
            </a>
        </li>
 <!--        <li>
            <a href="#">
                Change Password
            </a>
        </li>
        <li>
            <a href="/user/profiles">
                Game Profiles
            </a>
        </li>
        <li>
            <a href="#">
                Manage Classes
            </a>
        </li>
        <li>
            <a href="#">
                Reports &amp; Analytics
            </a>
        </li>
        <li>
            <label>Quiz Options</label>
        </li>
        <li>
            <a href="#">Create New Quiz</a>
        </li>
        <li>
            <a href="#">View Quiz</a>
        </li> -->
        <li>
            <a href="#" class="btn-logout">Logout</a>
        </li>
    </ul>
</aside>

<aside class="left-sidebar hide">
    <ul class="left-sidebar-list">
        <li>
            <label class="main-label">
                Dashboard
            </label>
        </li>
        @if ($sidebar_item === 'dashboard')
            <li>
                <a href="/user/profiles" class="active">
                    <i class="fa fa-tachometer"></i>
                    Member Dashboard
                </a>
            </li>
        @else
            <li>
                <a href="/user/profiles">
                    <i class="fa fa-tachometer"></i>
                    Member Dashboard
                </a>
            </li>
        @endif

        @if ($sidebar_item === 'setting')
            <li>
                <a href="/user/account" class="active">
                    <i class="fa fa-user"></i>
                    My Account
                </a>
            </li>
        @else
            <li>
                <a href="/user/account">
                    <i class="fa fa-user"></i>
                    My Account
                </a>
            </li>
        @endif

<!--         @if ($sidebar_item === 'change_password')
            <li>
                <a href="#" class="active">
                    <i class="fa fa-key"></i>
                    Change Password
                </a>
            </li>
        @else
            <li>
                <a href="#">
                    <i class="fa fa-key"></i>
                    Change Password
                </a>
            </li>
        @endif -->

<!--         @if ($sidebar_item === 'game_profiles')
            <li>
                <a href="/user/profiles" class="active">
                    <i class="fa fa-star"></i>
                    Game Profiles
                </a>
            </li>
        @else
            <li>
                <a href="/user/profiles">
                    <i class="fa fa-star"></i>
                    Game Profiles
                </a>
            </li>
        @endif -->

<!--         @if ($sidebar_item === 'classes')
            <li>
                <a href="#" class="active">
                    <i class="fa fa-users"></i>
                    Manage Classes
                </a>
            </li>
        @else
            <li>
                <a href="#">
                    <i class="fa fa-users"></i>
                    Manage Classes
                </a>
            </li>
        @endif -->

<!--         @if ($sidebar_item === 'reports')
            <li>
                <a href="#" class="active">
                    <i class="fa fa-line-chart"></i>
                    Reports &amp; Analytics
                </a>
            </li>
        @else
            <li>
                <a href="#">
                    <i class="fa fa-line-chart"></i>
                    Reports &amp; Analytics
                </a>
            </li>
        @endif -->

        <!-- <li>
            <label class="secondary-label">Quiz Options</label>
        </li>
        @if ($sidebar_item === 'new_quiz')
            <li>
                <a href="#" class="active">
                    <i class="fa fa-flask"></i>
                    Create New Quiz
                </a>
            </li>
        @else
            <li>
                <a href="#">
                    <i class="fa fa-flask"></i>
                    Create New Quiz
                </a>
            </li>
        @endif
        @if ($sidebar_item === 'view_quiz')
            <li>
                <a href="#" class="active">
                    <i class="fa fa-bolt"></i>
                    View Quiz
                </a>
            </li>
        @else
            <li>
                <a href="#">
                    <i class="fa fa-bolt"></i>
                    View Quiz
                </a>
            </li>
        @endif -->

        <li>
            <a href="#" class="btn-logout">
                <i class="fa fa-bolt"></i>
                Logout
            </a>
        </li>
    </ul>
</aside>

<aside class="left-sidebar hide-for-small">
    <ul class="left-sidebar-list">
        <li>
            <label class="main-label">
                Dashboard
            </label>
        </li>
        @if ($sidebar_item === 'dashboard')
            <li>
                <a href="/user/profiles" class="active">
                    <i class="fa fa-tachometer"></i>
                    Member Dashboard
                </a>
            </li>
        @else
            <li>
                <a href="/user/profiles">
                    <i class="fa fa-tachometer"></i>
                    Member Dashboard
                </a>
            </li>
        @endif
        @if ($sidebar_item === 'setting')
            <li>
                <a href="/user/account" class="active">
                    <i class="fa fa-user"></i>
                    My Account
                </a>
            </li>
        @else
            <li>
                <a href="/user/account">
                    <i class="fa fa-user"></i>
                    My Account
                </a>
            </li>
        @endif

        <!-- @if ($sidebar_item === 'change_password')
            <li>
                <a href="/user/change-password" class="active">
                    <i class="fa fa-key"></i>
                    Change Password
                </a>
            </li>
        @else
            <li>
                <a href="/user/change-password">
                    <i class="fa fa-key"></i>
                    Change Password
                </a>
            </li>
        @endif
        @if ($sidebar_item === 'game_profiles')
            <li>
                <a href="/user/profiles" class="active">
                    <i class="fa fa-star"></i>
                    Game Profiles
                </a>
            </li>
        @else
            <li>
                <a href="/user/profiles">
                    <i class="fa fa-star"></i>
                    Game Profiles
                </a>
            </li>
        @endif
        @if ($sidebar_item === 'classes')
            <li>
                <a href="/user/classes" class="active">
                    <i class="fa fa-users"></i>
                    Manage Classes
                </a>
            </li>
        @else
            <li>
                <a href="/user/classes">
                    <i class="fa fa-users"></i>
                    Manage Classes
                </a>
            </li>
        @endif
        @if ($sidebar_item === 'reports')
            <li>
                <a href="/user/reports" class="active">
                    <i class="fa fa-line-chart"></i>
                    Reports &amp; Analytics
                </a>
            </li>
        @else
            <li>
                <a href="/user/reports">
                    <i class="fa fa-line-chart"></i>
                    Reports &amp; Analytics
                </a>
            </li>
        @endif -->

  <!--       <li>
            <label class="secondary-label">Quiz Options</label>
        </li>
        @if ($sidebar_item === 'new_quiz')
            <li>
                <a href="/user/new-quiz" class="active">
                    <i class="fa fa-flask"></i>
                    Create New Quiz
                </a>
            </li>
        @else
            <li>
                <a href="/user/new-quiz">
                    <i class="fa fa-flask"></i>
                    Create New Quiz
                </a>
            </li>
        @endif
        @if ($sidebar_item === 'view_quiz')
            <li>
                <a href="/user/quizzes" class="active">
                    <i class="fa fa-bolt"></i>
                    View Quiz
                </a>
            </li>
        @else
            <li>
                <a href="/user/quizzes">
                    <i class="fa fa-bolt"></i>
                    View Quiz
                </a>
            </li>
        @endif -->
        <li>
            <a href="#" class="btn-logout">
                <i class="fa fa-bolt"></i>
                Logout
            </a>
        </li>
    </ul>
</aside>


@stop