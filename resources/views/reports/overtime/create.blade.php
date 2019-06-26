@extends('layouts.app')
@section('content')
    <div class="page-head">
        <div class="page-title">
            <h1>Overtime report</h1>
        </div>
    </div>
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a href="{{ url('/') }}">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{ url('reports/overtime/create') }}">Report</a>
        </li>
    </ul>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-body">
                        <form action="{{ url('reports/overtime') }}" role="form" method="post">
                            {{ csrf_field() }}
                           <div class="form-group">
                               <label for="month">Month</label>
                               <select class="form-control" name="month[]" id="month" required multiple>
                                   <option value="January">January</option>
                                   <option value="February">February</option>
                                   <option value="March">March</option>
                                   <option value="April">April</option>
                                   <option value="May">May</option>
                                   <option value="June">June</option>
                                   <option value="July">July</option>
                                   <option value="August">August</option>
                                   <option value="September">September</option>
                                   <option value="October">October</option>
                                   <option value="November">November</option>
                                   <option value="December">December</option>
                               </select>
                           </div>
                            <div class="form-group">
                                <label for="employee_id">Employee</label>
                                <select class="form-control" name="employee_id" id="employee_id" required>
                                    <option value="all" selected>All Employees</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}"{{ old('employee_id') == $employee->id ? ' selected' : '' }}>{{ getPayrollNumberPrefix() . $employee->payroll_number }}
                                            - {{ $employee->first_name }} {{ $employee->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="format">Format</label>
                                <select name="format" id="format" class="form-control">
                                    <option value="xls" selected>Excel XLS</option>
                                    <option value="xlsx">Excel 2007 and above XLSX</option>
                                    {{--<option value="pdf">PDF</option>--}}
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-success" value="Generate">
                                <a href="" class="btn btn-default">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
@section('footer')
    <script>
        $('#month').select2();
    </script>
    @endsection