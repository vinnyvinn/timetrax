<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Time and attendance') }}</title>

    <!-- Styles -->
    <link href="{{ asset(elixir('css/app.css')) }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
<nav class="navbar navbar-default navbar-static-top" id="mainNav">
    <div class="container">
        <div class="navbar-header">


            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Time and attendance') }}
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/') }}">Dashboard</a></li>
                @if(hasPermission(App\Role::PERM_ATTENDANCE_VIEW_INDIVIDUAL) || hasPermission(App\Role::PERM_ATTENDANCE_VIEW_ALL))
                    <li><a href="{{url('attendance') }}">Attendance</a></li>
                @endif
                @if(hasPermission(App\Role::PERM_EMPLOYEE_VIEW_ALL))
                    <li><a href="{{url('employee') }}">Employees</a></li>
                @endif
                @if(hasPermission(App\Role::PERM_LEAVE_VIEW_ALL))
                    <li><a href="{{url('leave') }}">Leaves</a></li>
                @endif
                <li><a href="{{url('user') }}">users</a></li>
                @if(hasPermission(App\Role::PERM_HOLIDAY_ADD))
                    <li><a href="{{url('holiday') }}">Holidays</a></li>
                @endif
                @if(hasPermission(App\Role::PERM_SETTINGS_VIEW))
                    <li><a href="{{url('settings')}}">Settings</a></li>
                @endif
                <li><a href="{{url('role')}}">Role</a></li>

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Login</a></li>

                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ url('/logout') }}"
                                   onclick="event.preventDefault();
document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

@yield('content')


@include('partials.footer')

<!-- Scripts -->
<script src="{{ asset(elixir('js/app.js')) }}"></script>
@yield('footer')
</body>
</html>
