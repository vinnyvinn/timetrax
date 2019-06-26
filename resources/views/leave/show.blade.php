@extends('layouts.app')
@section('content')
    <div class="page-head">
        <div class="page-title">
            <h1>Leaves</h1>
        </div>
    </div>
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a href="{{ url('/') }}">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{ route('leave.index') }}">Leaves</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="#">View</a>
        </li>
    </ul>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default col-sm-8 col-sm-offset-2">
                <div class="panel-heading">
                   <h4>View existing Leave</h4>
                </div>
                <div class="panel-body">
                    @if(count($errors))
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </div>
                    @endif
                        <div class="form-group">
                            <label for="employee_id">Employee</label>
                            <h4>{{ $details->employee->payroll_number }} - {{ $details->employee->first_name }} {{ $details->employee->last_name }}</h4>
                        </div>

                        <div class="form-group">
                            <label for="start_date">Leave Start</label>
                            <h4>{{ Carbon\Carbon::parse($details->start_date)->format('d F Y') }}</h4>
                        </div>

                        <div class="form-group">
                            <label for="end_date">Leave End</label>
                            <h4>{{ Carbon\Carbon::parse($details->end_date)->format('d F Y') }}</h4>
                        </div>

                        <div class="form-group">
                            <label for="employee_id">Status</label>
                            <h4>{{ $details->status }}</h4>
                        </div>
                        <div class="form-group">
                            <a href="{{ route('leave.edit', $details->id) }}" class="btn btn-primary">Edit</a>
                            <a href="{{ route('leave.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection
