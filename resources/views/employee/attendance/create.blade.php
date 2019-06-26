@extends('layouts.app')
@section('content')
    <div class="page-head">
        <div class="page-title">
            <h1>Employee attendance</h1>
        </div>
    </div>
    <ul class="breadcrumb page-breadcrumb">
        <li>
            <a href="{{ url('/') }}">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{ route('employee.index') }}">Employees</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="#">Attendance</a>
        </li>
    </ul>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Create Employee Attendance</h4>
                </div>
                <div class="panel-body">
                    <form action="{{ route('attendance.checkInOrOut') }}" method="post" role="form">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="employee_id">Employee</label>
                            <select class="form-control" name="employee_id" id="employee_id">
                                @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->payroll_number }}-{{ $employee->first_name }} {{ $employee->last_name }}</option>
                                @endforeach
                            </select>
                            {{--<span class="input-group-btn" id=""><a href="" class="btn btn-primary blue-salsa btn-xm active attend">--}}
                                {{--Punch In--}}
                            {{--</a></span>--}}
                        </div>
                        <div class="form-group">
                            <label for="site_id">Site</label>
                            <select class="form-control" name="site_id" id="site_id">
                                @foreach($sites as $site)
                                     <option value="{{ $site->id }}">{{ $site->name }}</option>   
                                 @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-success" value="Punch Card">
                            <a href="{{ route('employee.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection
{{--@section('footer')--}}
    {{--<script>--}}
        {{--$('#day').datepicker({--}}
            {{--autoclose:true,--}}
            {{--endDate: '0d'--}}
        {{--});--}}
    {{--</script>--}}
    {{--@endsection--}}