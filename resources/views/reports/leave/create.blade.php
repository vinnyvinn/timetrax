@extends('layouts.app')
@section('content')
    <div class="page-head">
        <div class="page-title">
            <h1>Leave report</h1>
        </div>
    </div>
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a href="{{ url('/') }}">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{ url('reports/leave/create') }}">Report</a>
        </li>
    </ul>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Enter the format of your report</h4>
                </div>
                    <div class="panel-body">
                        <form action="{{ url('reports/leave') }}" method = "post" role="form">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <select class="form-control" name="employee_id" name="employe_id" required>
                                    <option value="all" selected>All Employees</option>
                                    @foreach($employees as $employee)
                                        {{--{{ dd($employees) }}--}}
                                    <option value="{{ $employee->id }}"{{ old('employee->id') == $employee->id ? 'selected' : ''}} >{{ getPayrollNumberPrefix() . $employee->payroll_number }} - {{ $employee->first_name }} {{ $employee->last_name }}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="start_date">Start date</label>
                                <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control datepicker" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask="" id="start_date" name="start_date" required>
                            </div>
                            </div>
                            <div class="form-group">
                                <label for="end-date">End date</label>
                                <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control datepicker" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask="" id="end_date" name="end_date" required>
                            </div>
                            </div>
                            <div class="form-group">
                                <label for="employee_id">Status</label>
                                <select class="form-control" name="status" id="status" required>
                                    <option value="{{ \App\Leave::STATUS }}">Pending Request</option>
                                    <option value="{{ \App\Leave::DECLINED }}">Declined Request</option>
                                    <option value="{{ \App\Leave::APPROVED }}">Approved Request</option>
                                </select>
                            </div>
                        <div class="form-group">
                            <select name="format" id="format" class="form-control">
                                <option value="xls" selected>Excel XLS</option>
                                <option value="xlsx">Excel 2007 and above XLSX</option>
                                {{--<option value="pdf">PDF</option>--}}
                            </select>
                        </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-success" value="Generate">
                                <a href="{{ isset($employee->id) ? asset('/employees/'.$employee->id) : asset('attendance') }}"></a>
                                <a href="#" class="btn btn-warning">Cancel</a>
                    </div>
             </form>
            </div>
        </div>
      </div>
     </div>
    @endsection
@section('footer')
    <script>
        $(function () {
            $('.datepicker').datepicker({
                autoclose:true
            });
            $("#datemask").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
            $("[data-mask]").inputmask();
        });
    </script>
    @endsection