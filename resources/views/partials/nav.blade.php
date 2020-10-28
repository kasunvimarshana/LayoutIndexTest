<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="javascript:void(0);">{{ config('app.name') }}</a>
        </div>
        <ul class="nav navbar-nav">
            <li class=""><a href="{!! route('home', []) !!}">Home</a></li>
            @if( auth()->check() )
            @if( auth()->user()->role_id == App\Enums\RoleEnum::SuperAdmin )
            <li class=""><a href="{!! route('user.create', []) !!}">Users</a></li>
            <li class=""><a href="{!! route('post.create_admin_dashbord', []) !!}">Posts</a></li>
            @endif
            <li class=""><a href="{!! route('post.create', []) !!}">MyPosts</a></li>
            @endif
        </ul>
        <ul class="nav navbar-nav navbar-right">
            @if( auth()->check() )
                <li>
                    <a href="{!! route('login.doLogout', []) !!}" onclick="return confirm('Are you sure?')">
                        <span class="glyphicon glyphicon-log-out"></span> Logout
                    </a>
                </li>
            @else
                <li>
                    <a href="{!! route('login.create', []) !!}">
                        <span class="glyphicon glyphicon-log-in"></span> Login
                    </a>
                </li>
            @endif
        </ul>
    </div>
</nav>