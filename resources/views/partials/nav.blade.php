<div class="page-header navbar navbar-fixed-top">
    <div class="page-header-inner">

        <div class="page-logo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('img/timetrax_logo.png') }}" style="height: 40px;"/>
                {{--Time<span>trax</span>--}}
            </a>

        </div>
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"></a>

        <!-- BEGIN PAGE TOP -->
        <div class="page-top">
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                @if (! is_null($checkin))
                <a href="{{ route('attendance.show', 'checkin') }}" class="btn btn-primary blue-salsa btn-xm active attend">
                    Punch In
                </a>
                @endif
                <ul class="nav navbar-nav pull-right">
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <li class="dropdown dropdown-user dropdown-dark">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<span class="username username-hide-on-mobile">
                            {{ Auth::user()->name }}
                        </span>
                            <!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="{{ url('change-password') }}">
                                    <i class="icon-user"></i> Change Password</a>
                                {{--<a href="{{ url('') }}"></a>--}}
                            </li>
                            <li>
                                <a href="{{ url('/logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="icon-power"></i>
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>

                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END PAGE TOP -->
    </div>
    <!-- END HEADER INNER -->
</div>
<div class="clearfix">
</div>