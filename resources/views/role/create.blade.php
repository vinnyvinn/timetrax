@extends('layouts.app')
@section('content')
    <div>
        <div class="page-head">
            <div class="page-title">
                <h1>User group</h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ route('role.index') }}">user groups</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ route('role.create') }}">Create</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>User Groups  </h4>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('role.store') }}" method="post" role="form" class="form-horizontal">
                            {{ csrf_field() }}
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="name">Group Name</label>
                                    <input type="text" class="form-control" id="name" name="name" pattern="([a-zA-Z]+$)"
                                           title="please enter text only" required>
                                </div>
                            </div>

                            <!-- col-left -->
                            <div class="col-sm-6">
                                <!-- Attendance -->
                                <div>
                                    <hr>
                                    <h4 class="text-center">ATTENDANCE</h4>
                                    <div class="form-group">
                                        <label for="attendance.view" class="col-sm-3">View</label>
                                        <div class="col-sm-6">
                                            <select class="form-control input-sm" name="permissions[]">
                                                <option value="none">None</option>
                                                <option value="0">All</option>
                                                <option value="1">Individual</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Attendance -->

                                <!-- Employees -->
                                <div>
                                    <hr>
                                    <h4 class="text-center">EMPLOYEES DETAILS</h4>
                                    <div class="form-group">
                                        <label for="employee.view" class="col-sm-3">View</label>
                                        <div class="col-sm-6">
                                            <select class="form-control input-sm" name="permissions[]">
                                                <option value="none">None</option>
                                                <option value="2">All</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="employee.add" class="col-sm-3">Add</label>
                                        <div class="col-sm-6">
                                            <select class="form-control input-sm" name="permissions[]">
                                                <option value="disabled">No</option>
                                                <option value="3">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="employee.edit" class="col-sm-3">Edit</label>
                                        <div class="col-sm-6">
                                            <select class="form-control input-sm" name="permissions[]">
                                                <option value="disabled">No</option>
                                                <option value="4">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="employee.delete" class="col-sm-3">Delete</label>
                                        <div class="col-sm-6">
                                            <select class="form-control input-sm" name="permissions[]">
                                                <option value="disabled">No</option>
                                                <option value="5">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <hr>
                                    <h4 class="text-center">LEAVES</h4>
                                    <div class="form-group">
                                        <label for="leave.view" class="col-sm-3">View</label>
                                        <div class="col-sm-6">
                                            <select class="form-control input-sm" name="permissions[]">
                                                <option value="none">None</option>
                                                <option value="6">All</option>
                                                <option value="7">Individual</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="leave.add" class="col-sm-3">Add</label>
                                        <div class="col-sm-6">
                                            <select class="form-control input-sm" name="permissions[]">
                                                <option value="disabled">No</option>
                                                <option value="8">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="leave.edit" class="col-sm-3">Edit</label>
                                        <div class="col-sm-6">
                                            <select class="form-control input-sm" name="permissions[]">
                                                <option value="disabled">No</option>
                                                <option value="9">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="leave.view" class="col-sm-3">Delete</label>
                                        <div class="col-sm-6">
                                            <select class="form-control input-sm" name="permissions[]">
                                                <option value="disabled">No</option>
                                                <option value="10">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="leave.view" class="col-sm-3">View Settings</label>
                                        <div class="col-sm-6">
                                            <select class="form-control input-sm" name="permissions[]">
                                                <option value="disabled">No</option>
                                                <option value="27">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- /Employees -->
                                <div>
                                    <hr>
                                    <h4 class="text-center">SETTINGS</h4>
                                    <div class="form-group">
                                        <label for="settings.view" class="col-sm-3">View</label>
                                        <div class="col-sm-6">
                                            <select class="form-control input-sm" name="permissions[]">
                                                <option value="No">No</option>
                                                <option value="11">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="settings.add" class="col-sm-3">Add</label>
                                        <div class="col-sm-6">
                                            <select class="form-control input-sm" name="permissions[]">
                                                <option value="No">No</option>
                                                <option value="12">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="settings.edit" class="col-sm-3">Edit</label>
                                        <div class="col-sm-6">
                                            <select class="form-control input-sm" name="permissions[]">
                                                <option value="No">No</option>
                                                <option value="13">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <div>
                                    <h4 class="text-center">HOLIDAYS</h4>
                                    <div class="form-group">
                                        <label for="holiday.add" class="col-sm-3">Add</label>
                                        <div class="col-sm-6">
                                            <select class="form-control input-sm" name="permissions[]">
                                                <option value="No">No</option>
                                                <option value="14">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    {{--<div class="form-group">--}}
                                    {{--<label for="holiday.edit" class="col-sm-3">Edit</label>--}}
                                    {{--<div class="col-sm-6">--}}
                                    {{--<select class="form-control input-sm" name="permissions[]">--}}
                                    {{--<option value="no">No</option>--}}
                                    {{--<option value="14">Yes</option>--}}
                                    {{--</select>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    <div class="form-group">
                                        <label for="holiday.delete" class="col-sm-3">Delete</label>
                                        <div class="col-sm-6">
                                            <select class="form-control input-sm" name="permissions[]">
                                                <option value="no">No</option>
                                                <option value="15">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <div>
                                    <h4 class="text-center">EMPLOYEE ATTENDANCE</h4>
                                    <div class="form-group">
                                        <label for="role.view" class="col-sm-3">View</label>
                                        <div class="col-sm-6">
                                            <select class="form-control input-sm" name="permissions[]">
                                                <option value="No">No</option>
                                                <option value="35">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="employee.view" class="col-sm-3">Add</label>
                                        <div class="col-sm-6">
                                            <select class="form-control input-sm" name="permissions[]">
                                                <option value="disabled">No</option>
                                                <option value="36">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <!-- /col-left -->

                            <!-- col-right -->

                            <div class="col-sm-6">
                                <hr>
                                <h4 class="text-center">ROLES</h4>
                                <div class="form-group">
                                    <label for="role.view" class="col-sm-3">View</label>
                                    <div class="col-sm-6">
                                        <select class="form-control input-sm" name="permissions[]">
                                            <option value="No">No</option>
                                            <option value="16">Yes</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="role.add" class="col-sm-3">Add</label>
                                    <div class="col-sm-6">
                                        <select class="form-control input-sm" name="permissions[]">
                                            <option value="No">No</option>
                                            <option value="17">Yes</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="role.edit" class="col-sm-3">Edit</label>
                                    <div class="col-sm-6">
                                        <select class="form-control input-sm" name="permissions[]">
                                            <option value="No">No</option>
                                            <option value="18">Yes</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="role.delete" class="col-sm-3">Delete</label>
                                    <div class="col-sm-6">
                                        <select class="form-control input-sm" name="permissions[]">
                                            <option value="No">No</option>
                                            <option value="19">Yes</option>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <div>
                                    <h4 class="text-center">OVERTIME</h4>
                                    <div class="form-group">
                                        <label for="role.view" class="col-sm-3">View</label>
                                        <div class="col-sm-6">
                                            <select class="form-control input-sm" name="permissions[]">
                                                <option value="No">No</option>
                                                <option value="20">All</option>
                                                <option value="21">Individual</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="employee.view" class="col-sm-3">View Settings</label>
                                        <div class="col-sm-6">
                                            <select class="form-control input-sm" name="permissions[]">
                                                <option value="disabled">No</option>
                                                <option value="28">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <hr>
                                    <h4 class="text-center">SHIFTS</h4>
                                    <div class="form-group">
                                        <label for="employee.view" class="col-sm-3">View</label>
                                        <div class="col-sm-6">
                                            <select class="form-control input-sm" name="permissions[]">
                                                <option value="none">None</option>
                                                <option value="23">All</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="employee.add" class="col-sm-3">Add</label>
                                        <div class="col-sm-6">
                                            <select class="form-control input-sm" name="permissions[]">
                                                <option value="disabled">No</option>
                                                <option value="24">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="employee.edit" class="col-sm-3">Edit</label>
                                        <div class="col-sm-6">
                                            <select class="form-control input-sm" name="permissions[]">
                                                <option value="disabled">No</option>
                                                <option value="25">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="employee.delete" class="col-sm-3">Delete</label>
                                        <div class="col-sm-6">
                                            <select class="form-control input-sm" name="permissions[]">
                                                <option value="disabled">No</option>
                                                <option value="26">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="text-center">REPORT</h4>
                                    <div class="form-group">
                                        <label for="role.view" class="col-sm-3">View</label>
                                        <div class="col-sm-6">
                                            <select class="form-control input-sm" name="permissions[]">
                                                <option value="No">No</option>
                                                <option value="22">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <div>
                                    <h4 class="text-center"> BULK ATTENDANCES</h4>
                                    <div class="form-group">
                                        <label for="role.view" class="col-sm-3">Create</label>
                                        <div class="col-sm-6">
                                            <select class="form-control input-sm" name="permissions[]">
                                                <option value="No">No</option>
                                                <option value="29">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    </hr>
                                </div>
                                <div>
                                    <hr>
                                    <h4 class="text-center">COMPANY</h4>
                                    <div class="form-group">
                                        <label for="company.view" class="col-sm-3">View</label>
                                        <div class="col-sm-6">
                                            <select class="form-control input-sm" name="permissions[]">
                                                <option value="30">All</option>
                                                <option value="31">Individual</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="company.add" class="col-sm-3">Add</label>
                                        <div class="col-sm-6">
                                            <select class="form-control input-sm" name="permissions[]">
                                                <option value="No">No</option>
                                                <option value="32">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="company.edit" class="col-sm-3">Edit</label>
                                        <div class="col-sm-6">
                                            <select class="form-control input-sm" name="permissions[]">
                                                <option value="No">No</option>
                                                <option value="34">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="company.delete" class="col-sm-3">Delete</label>
                                        <div class="col-sm-6">
                                            <select class="form-control input-sm" name="permissions[]">
                                                <option value="No">No</option>
                                                <option value="33">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <hr>
                                    <h4 class="text-center">Sites</h4>
                                    <div class="form-group">
                                        <label for="company.view" class="col-sm-3">Add</label>
                                        <div class="col-sm-6">
                                            <select class="form-control input-sm" name="permissions[]">
                                                <option value="No">No</option>
                                                <option value="37">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="Create">
                                    <a href="{{ route('role.index') }}" class="btn btn-danger">Cancel</a>
                                </div>
                            </div>
                        </form>
                        <!-- /col-right -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')

@endsection