@extends('layouts.app')
@section('content')
    <div class="page-head">
        <div class="page-title">
            <h1>Roles</h1>
        </div>
    </div>
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a href="{{ url('/') }}">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{ route('role.index') }}">Roles</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="#">Edit</a>
        </li>
    </ul>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    User Groups
                </div>
                <div class="panel-body">
                    <form action="{{ route('role.update', $details->id) }}" method="post" role="form"
                          class="form-horizontal">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="name">Group Name</label>
                                <input type="text" class="form-control" id="name" name="name" required
                                       value="{{ $details->name }}" 
                                       title="please enter text only">
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
                                            <option value="0"{{ in_array(0, $details->permissions) ? ' selected' : '' }}>
                                                All
                                            </option>
                                            <option value="1"{{ in_array(1, $details->permissions) ? ' selected' : '' }}>
                                                Individual
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- /Attendance -->

                            <!-- Employees -->
                            <div>
                                <hr>
                                <h4 class="text-center">EMPLOYEES</h4>
                                <div class="form-group">
                                    <label for="employee.view" class="col-sm-3">View</label>
                                    <div class="col-sm-6">
                                        <select class="form-control input-sm" name="permissions[]">
                                            <option value="none">None</option>
                                            <option value="2"{{ in_array(2, $details->permissions) ? ' selected' : '' }}>
                                                All
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="employee.add" class="col-sm-3">Add</label>
                                    <div class="col-sm-6">
                                        <select class="form-control input-sm" name="permissions[]">
                                            <option value="disabled">No</option>
                                            <option value="3"{{ in_array(3, $details->permissions) ? ' selected' : '' }}>
                                                Yes
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="employee.edit" class="col-sm-3">Edit</label>
                                    <div class="col-sm-6">
                                        <select class="form-control input-sm" name="permissions[]">
                                            <option value="disabled">No</option>
                                            <option value="4"{{ in_array(4, $details->permissions) ? ' selected' : '' }}>
                                                Yes
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="employee.delete" class="col-sm-3">Delete</label>
                                    <div class="col-sm-6">
                                        <select class="form-control input-sm" name="permissions[]">
                                            <option value="disabled">No</option>
                                            <option value="5" {{ in_array(5, $details->permissions) ? 'selected' : '' }}>
                                                Yes
                                            </option>
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
                                            <option value="6" {{ in_array(6, $details->permissions) ? 'selected' : '' }}>
                                                All
                                            </option>
                                            <option value="7" {{ in_array(7, $details->permissions) ? 'selected' : '' }}>
                                                Individual
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="leave.add" class="col-sm-3">Add</label>
                                    <div class="col-sm-6">
                                        <select class="form-control input-sm" name="permissions[]">
                                            <option value="disabled">No</option>
                                            <option value="8" {{ in_array(8, $details->permissions) ? 'selected' : '' }}>
                                                Yes
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="leave.edit" class="col-sm-3">Edit</label>
                                    <div class="col-sm-6">
                                        <select class="form-control input-sm" name="permissions[]">
                                            <option value="disabled">No</option>
                                            <option value="9" {{ in_array(9, $details->permissions) ? 'selected' : '' }} >
                                                Yes
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="leave.view" class="col-sm-3">Delete</label>
                                    <div class="col-sm-6">
                                        <select class="form-control input-sm" name="permissions[]">
                                            <option value="disabled">No</option>
                                            <option value="10" {{ in_array(10, $details->permissions) ? 'selected' : '' }}>
                                                Yes
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="leave.view" class="col-sm-3">View Settings</label>
                                    <div class="col-sm-6">
                                        <select class="form-control input-sm" name="permissions[]">
                                            <option value="disabled">No</option>
                                            <option value="27" {{ in_array(27, $details->permissions) ? 'selected' : '' }}>
                                                Yes
                                            </option>
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
                                            <option value="11" {{ in_array(11, $details->permissions) ? 'selected' : '' }}>
                                                Yes
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="settings.add" class="col-sm-3">Add</label>
                                    <div class="col-sm-6">
                                        <select class="form-control input-sm" name="permissions[]">
                                            <option value="No">No</option>
                                            <option value="12" {{ in_array(12, $details->permissions) ? 'selected' : '' }}>
                                                Yes
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="settings.edit" class="col-sm-3">Edit</label>
                                    <div class="col-sm-6">
                                        <select class="form-control input-sm" name="permissions[]">
                                            <option value="No">No</option>
                                            <option value="13" {{ in_array(13, $details->permissions) ? 'selected' : '' }}>
                                                Yes
                                            </option>
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
                                            <option value="14" {{ in_array(14, $details->permissions) ? 'selected' : '' }}>
                                                Yes
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="holiday.edit" class="col-sm-3">Edit</label>
                                    <div class="col-sm-6">
                                        <select class="form-control input-sm" name="permissions[]">
                                            <option value="no">No</option>
                                            <option value="15" {{ in_array(15, $details->permissions) ? 'selected' : '' }}>
                                                Yes
                                            </option>
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
                                            <option value="35" {{ in_array(35, $details->permissions) ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="employee.view" class="col-sm-3">Add</label>
                                    <div class="col-sm-6">
                                        <select class="form-control input-sm" name="permissions[]">
                                            <option value="disabled">No</option>
                                            <option value="36" {{ in_array(36, $details->permissions) ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- /col-left -->

                        <!-- col-right -->

                        <div class="col-sm-6">
                            <h4 class="text-center">ROLES</h4>
                            <div class="form-group">
                                <label for="role.view" class="col-sm-3">View</label>
                                <div class="col-sm-6">
                                    <select class="form-control input-sm" name="permissions[]">
                                        <option value="no">No</option>
                                        <option value="16" {{ in_array(16, $details->permissions) ? 'selected' : '' }}>
                                            Yes
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="role.add" class="col-sm-3">Add</label>
                                <div class="col-sm-6">
                                    <select class="form-control input-sm" name="permissions[]">
                                        <option value="no">No</option>
                                        <option value="17" {{ in_array(17, $details->permissions) ? 'selected' : '' }}>
                                            Yes
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="role.edit" class="col-sm-3">Edit</label>
                                <div class="col-sm-6">
                                    <select class="form-control input-sm" name="permissions[]">
                                        <option value="no">No</option>
                                        <option value="18" {{ in_array(18, $details->permissions) ? 'selected' : '' }}>
                                            Yes
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="role.delete" class="col-sm-3">Delete</label>
                                <div class="col-sm-6">
                                    <select class="form-control input-sm" name="permissions[]">
                                        <option value="no">No</option>
                                        <option value="19" {{ in_array(19, $details->permissions) ? 'selected' : '' }}>
                                            Yes
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-center">OVERTIME</h4>
                                <div class="form-group">
                                    <label for="role.view" class="col-sm-3">View</label>
                                    <div class="col-sm-6">
                                        <select class="form-control input-sm" name="permissions[]">
                                            <option value="No">No</option>
                                            <option value="20" {{ in_array(20, $details->permissions) ? 'selected' : '' }}>
                                                All
                                            </option>
                                            <option value="21" {{ in_array(21, $details->permissions) ? 'selected' : '' }}>
                                                Individual
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="overtime.view" class="col-sm-3">View Settings</label>
                                    <div class="col-sm-6">
                                        <select class="form-control input-sm" name="permissions[]">
                                            <option value="disabled">No</option>
                                            <option value="28" {{ in_array(28, $details->permissions) ? 'selected' : '' }}>
                                                Yes
                                            </option>
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
                                            <option value="23"{{ in_array(23, $details->permissions) ? ' selected' : '' }}>
                                                All
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="employee.add" class="col-sm-3">Add</label>
                                    <div class="col-sm-6">
                                        <select class="form-control input-sm" name="permissions[]">
                                            <option value="disabled">No</option>
                                            <option value="24"{{ in_array(24, $details->permissions) ? ' selected' : '' }}>
                                                Yes
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="employee.edit" class="col-sm-3">Edit</label>
                                    <div class="col-sm-6">
                                        <select class="form-control input-sm" name="permissions[]">
                                            <option value="disabled">No</option>
                                            <option value="25"{{ in_array(25, $details->permissions) ? ' selected' : '' }}>
                                                Yes
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="employee.delete" class="col-sm-3">Delete</label>
                                    <div class="col-sm-6">
                                        <select class="form-control input-sm" name="permissions[]">
                                            <option value="disabled">No</option>
                                            <option value="26" {{ in_array(26, $details->permissions) ? 'selected' : '' }}>
                                                Yes
                                            </option>
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
                                            <option value="22" {{ in_array(22, $details->permissions) ? 'selected' : '' }}>
                                                Yes
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-center"> Bulk Attendances</h4>
                                <div class="form-group">
                                    <label for="role.view" class="col-sm-3">Create</label>
                                    <div class="col-sm-6">
                                        <select class="form-control input-sm" name="permissions[]">
                                            <option value="No">No</option>
                                            <option value="29" {{ in_array(29, $details->permissions) ? 'selected' : '' }}>
                                                Yes
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <hr>
                                <h4 class="text-center">COMPANY</h4>
                                <div class="form-group">
                                    <label for="company.view" class="col-sm-3">View</label>
                                    <div class="col-sm-6">
                                        <select class="form-control input-sm" name="permissions[]">
                                            <option value="30" {{ in_array(30, $details->permissions) ? 'selected' : '' }}>
                                                All
                                            </option>
                                            <option value="31" {{ in_array(31, $details->permissions) ? 'selected' : '' }}>
                                                Individual
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                {{--@if(in_array(30, $details->permissions) == 'selected')--}}
                                    {{--<div class="form-group">--}}
                                        {{--<label for="company" class="col-sm-3">Company Name</label>--}}
                                        {{--<div class="col-sm-6">--}}
                                            {{--<select class="form-control" multiple name="name" id="name">--}}
                                                {{--@foreach($companies as $company)--}}
                                                    {{--<option value="{{ $company->id }}" selected="selected"--}}
                                                    {{-->{{ $company->name }}</option>--}}
                                                {{--@endforeach--}}
                                            {{--</select>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--@endif--}}
                                <div class="form-group">
                                    <label for="company.add" class="col-sm-3">Add</label>
                                    <div class="col-sm-6">
                                        <select class="form-control input-sm" name="permissions[]">
                                            <option value="No">No</option>
                                            <option value="32" {{ in_array(32, $details->permissions) ? 'selected' : '' }}>
                                                Yes
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="company.edit" class="col-sm-3">Edit</label>
                                    <div class="col-sm-6">
                                        <select class="form-control input-sm" name="permissions[]">
                                            <option value="No">No</option>
                                            <option value="34" {{ in_array(34, $details->permissions) ? 'selected' : '' }}>
                                                Yes
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="company.delete" class="col-sm-3">Delete</label>
                                    <div class="col-sm-6">
                                        <select class="form-control input-sm" name="permissions[]">
                                            <option value="No">No</option>
                                            <option value="33" {{ in_array(33, $details->permissions) ? 'selected' : '' }}>
                                                Yes
                                            </option>
                                        </select>
                                    </div>
                                <div>
                                    <hr>
                                    <h4 class="text-center">Sites</h4>
                                    <div class="form-group">
                                        <label for="company.view" class="col-sm-3">Add</label>
                                        <div class="col-sm-6">
                                            <select class="form-control input-sm" name="permissions[]">
                                                <option value="No">No</option>
                                                <option value="37" {{ in_array(37, $details->permissions) ? 'selected' : '' }}>Yes</option>
                                            </select>
                                        </div>
                                    </div>
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

                        <!-- /col-right -->
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('footer')
    <script>
        $('select#name').select2();
    </script>
@endsection