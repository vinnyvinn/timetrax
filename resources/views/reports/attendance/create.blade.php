@extends('layouts.app')
@section('content')
    <div class="page-head">
        <div class="page-title">
            <h1>Attendance report</h1>
        </div>
    </div>
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a href="{{ url('/') }}">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{ url('reports/attendance/create') }}">Report</a>
        </li>
    </ul>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Enter the format of your report</h4>
                </div>
                <form action="{{ url('reports/attendance') }}" target="_blank" method="post">
                    {{ csrf_field() }}
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="payroll_number">Payroll number</label>
                            <select class="form-control" name="employee_id" id="employee_id" required>
                                <option value="all" selected>All Employees</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}"{{ old('employee->id') == $employee->id ? 'selected' : ''}}>{{ getPayrollNumberPrefix() . $employee->payroll_number }}
                                        - {{ $employee->first_name }} {{ $employee->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group ">
                            <label for="start_date">Start date</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control datepicker"
                                       data-inputmask="'alias': 'mm/dd/yyyy'" data-mask="" name="start_date"
                                       id="start_date" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="end-date">End date</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control datepicker"
                                       data-inputmask="'alias': 'mm/dd/yyyy'" data-mask="" name="end_date" id="end_date"
                                       required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="shift">Assigned Shifts</label>
                            <select name="shift_id[]" id="shift_id" class="form-control" multiple>
                                @foreach($shifts as $shift)
                                    <option value="{{ $shift->id }}"{{ $shift->id ? ' selected' : '' }}>{{ $shift->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="format">Format</label>
                            <select name="format" id="format" class="form-control">
                                <option value="xls" selected>Excel XLS</option>
                                {{--<option value="pdf">PDF</option>--}}
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" value="Generate">
                            <a href="{{ isset($employee->id) ? asset('/employees/'.$employee->id) : asset('attendance') }}"></a>
                            <a href="{{ route('reports.attendance.create') }}" class="btn btn-warning">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        $(function () {
            $('.datepicker').datepicker({
                autoclose: true,
            
            });
//            $("#datemask").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
//            $("[data-mask]").inputmask();

            $('#shift_id').select2();
        }());
    </script>
@endsection