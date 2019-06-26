@extends('layouts.app')
@section('content')
    <div class="col-sm-offset-2 col-sm-8">
        <div class="page-head">
            <div class="page-title">
                <h1>Attendances - <small> Check in or out</small></h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb col-sm-8-offset-2">
            <li>
                <a href="{{ url('/') }}">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ route('attendance.index') }}">Attendances</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="#">Create Attendance</a>
            </li>
        </ul>
    </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default col-sm-8 col-sm-offset-2">
                    <div class="panel-heading">
                        <h4>Set new Attendance</h4>
                    </div>
                    <div class="panel-body">
                        @if(count($errors))
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </div>
                        @endif
                        <form action="{{ route('attendance.store') }}" method="post" role="form">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="employee_id">Employee</label>
                                <select class="form-control" name="employee_id" id="employee_id" required>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}"{{ old('employee_id') == $employee->id ? ' selected' : '' }}>{{ $employee->payroll_number }}
                                            - {{ $employee->first_name }} {{ $employee->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group time_in">
                                <label for="time_in">Check In</label>
                                <input type="text" class="form-control" id="time_in" name="time_in"
                                       value="{{ old('time_in') }}" required>
                            </div>

                            <div class="form-group time_out">
                                <label for="time_out">Check Out</label>
                                <input type="text" class="form-control" id="time_out" name="time_out"
                                       value="{{ old('time_out') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="day">Day</label>
                                <input type="text" class="form-control" id="day" name="day"
                                       value="{{ old('day') }}" required>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-success" type="submit">
                                    Create Attendance
                                </button>
                                <a href="{{ route('attendance.index') }}" class="btn btn-danger">Cancel</a>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
@section('footer')
    <script>
        $('#day').datepicker({
            autoclose:true,
            endDate: '0d'
        });
        $('#time_out, #time_in').timepicker();
        $('#attendanceTable').dataTable();
    </script>
    @endsection