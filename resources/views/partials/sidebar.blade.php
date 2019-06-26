<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <li class="start active ">
                <a href="{{ url('/') }}">
                    <i class="icon-home"></i>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            @if(hasPermission(App\Role::PERM_COMPANY_VIEW_ALL) || hasPermission(App\Role::PERM_COMPANY_VIEW_INDIVIDUAL))
                <li>
                    <a href="{{ url('/company') }}">
                        <i class="icon-note"></i>
                        <span class="title">Company</span>
                    </a>
                </li>
            @endif
            @if(hasPermission(App\Role::PERM_SHIFT_VIEW))
                <li>
                    <a href="{{ url('/shift') }}">
                        <i class="icon-clock"></i>
                        <span class="title">Shifts</span>
                    </a>
                </li>
            @endif
                <li>
                    <a href="">
                        <i class="icon-user"></i>
                        <span class="title">Employees</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                    @if(hasPermission(App\Role::PERM_EMPLOYEE_VIEW_ALL))
                        <li><a href="{{ url('/employee') }}">Employee Details</a></li>
                        <!-- <li> <a href="{{url('/emp/category')}}">Employee Category</li> -->

                    @endif
                        @if(hasPermission(App\Role::PERM_EMPLOYEE_ATTENDANCE_VIEW) || hasPermission(App\Role::PERM_EMPLOYEE_ATTENDANCE_ADD))
                        <li><a href="{{ url('/employee/attendance') }}">Employee Attendance</a></li>
                         @endif

                    </ul>
                </li>
            @if(hasPermission(App\Role::PERM_ATTENDANCE_VIEW_INDIVIDUAL) || hasPermission(App\Role::PERM_ATTENDANCE_VIEW_ALL))
                <li>
                    <a href="{{ url('/attendance') }}">
                        <i class="icon-note"></i>
                        <span class="title">Attendance</span>
                    </a>
                    {{--<ul class="sub-menu">--}}
                    {{--<li>--}}
                    {{--<a href="{{ url('reports/attendance/create') }}"><i class="icon-settings"></i> Settings</a>--}}
                    {{--</li>--}}
                    {{--</ul>--}}
                </li>
            @endif

            @if(hasPermission(App\Role::PERM_OVERTIME_VIEW_ALL) || hasPermission(App\Role::PERM_OVERTIME_VIEW_INDIVIDUAL) )
                @if($configs->where('setting_key', 'overtime')->first()->setting_value == 'enabled')
                    <li>
                        <a href="javascript:;">
                            <i class="icon-plus"></i>
                            <span class="title">Overtime</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            {{--<li>--}}
                            {{--<a href="{{ url('reports/overtime/create') }}">Overtime</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="{{ url('/overtime') }}"><i class="icon-user"></i> Employee Overtime</a>--}}
                            {{--</li>--}}
                            @if(hasPermission(App\Role::PERM_VIEW_OVERTIME_SETTINGS))
                            <li>
                                <a href="{{ url('settings/overtime-settings') }}"><i class="icon-settings"></i> Settings</a>
                            </li>
                            @endif
                        </ul>
                    </li>
                @endif
            @endif

            @if(hasPermission(App\Role::PERM_LEAVE_VIEW_ALL) || hasPermission(App\Role::PERM_LEAVE_VIEW_INDIVIDUAL))
                @if($configs->where('setting_key', 'leave')->first()->setting_value == 'enabled')
                    <li>
                        <a href="javascript:;">
                            <i class="icon-rocket"></i>
                            <span class="title">Leaves</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="{{ url('/leave') }}"><i class="icon-user"></i> Employee leaves</a>
                            </li>
                            @if(hasPermission(App\Role::PERM_VIEW_LEAVE_SETTINGS))

                            <li>
                                <a href="{{ url('settings/leave-settings') }}"><i class="icon-settings"></i>
                                  Catgories  </a>
                            </li>
                              <li>
                                <a href="{{ url('settings/leave-import') }}"><i class="icon-tag"></i>
                                  Settings  </a>
                            </li>

                                @endif
                        </ul>
                    </li>
                @endif
            @endif
            @if(hasPermission(App\Role::PERM_HOLIDAY_ADD))
                <li>
                    <a href="{{ url('/holiday') }}">
                        <i class="icon-calendar"></i>
                        <span class="title">Holidays</span>
                    </a>
                </li>
            @endif
            @if(hasPermission(App\Role::PERM_ROLE_VIEW_ALL))
                <li>
                    <a href="{{ url('/role') }}">
                        <i class="icon-users"></i>
                        <span class="title">User Groups</span>
                    </a>
                </li>
            @endif
            <li>
                <a href="{{ url('sites') }}">
                    <i class="icon-tag"></i>
                    <span class="title">Sites</span>
                </a>
            </li>
            @if(hasPermission(App\Role::PERM_SETTINGS_VIEW))
                <li>
                    <a href="javascript:;">
                        <i class="icon-settings"></i>
                        <span class="title">Settings</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="{{ url('/leave') }}"><i class="icon-user"></i> Calender</a>
                        </li>
                        @if(hasPermission(App\Role::PERM_VIEW_LEAVE_SETTINGS))
                        <li>
                            <a href="{{ url('settings') }}">
                             <i class="icon-settings"></i>
                               System Settings
                            </a>
                        </li>
                        <li>
                         <a href="{{ url('calendar') }}">
                             <i class="icon-settings"></i>
                               Working Days
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
            @endif

            {{--<li>--}}
            {{--<a href="{{ url('/report') }}">--}}
            {{--<i class="icon-clock"></i>--}}
            {{--<span class="title">Report</span>--}}
            {{--</a>--}}
            {{--</li>--}}
            @if(hasPermission(App\Role::PERM_REPORT_VIEW_ALL))
                <li class="last ">
                    <a href="javascript:;">
                        <i class="icon-docs"></i>
                        <span class="title">Reports</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="{{ url('reports/attendance/create') }}"><i class="icon-note"></i> Attendance</a>
                        </li>
                        {{--<li>--}}
                            {{--<a href="{{ url('reports/attendanceSummary/create') }}"><i class="icon-note"></i> Attendance Summary</a>--}}
                        {{--</li>--}}
                        <li>
                        <a href="{{ url('reports/overtime/create') }}"><i class="icon-plus"></i>Overtime</a>
                        <a href="{{ url('reports/exception/create') }}"><i class="icon-plus"></i>Exception Reports</a>
                        </li>
                        <li>
                            <a href="{{ url('reports/employee/create') }}"><i class="icon-user"></i> Employees</a>
                        </li>
                        <li>
                            <a href="{{ url('reports/leave/create') }}"><i class="icon-rocket"></i> Leaves</a>
                        </li>
                        <li>
                            <a href="{{ url('reports/shift/create') }}"><i class="icon-clock"></i> Shifts</a>
                        </li>
                        <li>
                            <a href="{{ url('newreports') }}"><i class="fa fa-line-chart"></i> Analysis</a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>
