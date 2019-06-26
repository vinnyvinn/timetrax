@extends('layouts.app')
@section('content')
    <div class="page-head">
        <div class="page-title">
            <h1>Employee report</h1>
        </div>
    </div>
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a href="{{ url('/') }}">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{ url('reports/employee/create') }}">Report</a>
        </li>
    </ul>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Enter the format of your report</h4>
                </div>
                <div class="panel-body">
                    <form action="{{ url('reports/employee') }}" method="post">
                        {{ csrf_field() }}
                    <div class="form-group">
                        <select name="format" id="format" class="form-control">
                            <option value="xls" selected>Excel XLS</option>
                            <option value="xlsx">Excel 2007 and above XLSX</option>
                            {{--<option value="pdf">PDF</option>--}}
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-success" value="Generate">
                        {{--<a href="{{ isset($employee->id) ? asset('/employees/'.$employee->id) : asset('employee') }}"></a>--}}
                        <a href="{{ route('reports.employee.create') }}" class="btn btn-warning">Cancel</a>
                    </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    @endsection