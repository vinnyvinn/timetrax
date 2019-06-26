@extends('layouts.app')
@section('content')
    <div class="page-head">
        <div class="page-title">
            <h1>Employees</h1>
        </div>
    </div>
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a href="{{ url('/') }}">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{ route('employee.index') }}">Employees</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="#">Import</a>
        </li>
    </ul>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Edit existing employee <a href="{{asset('employee_uploda_template.csv')}}"><label class="label label-success"> Download Template </label></a></h4>
                </div>
                <div class="panel-body">
                    <form action="{{ route('employee/importCSV') }}" method="post" role="form" enctype="multipart/form-data">
                        {{  csrf_field() }}
                        	<div class="form-group">
                        			<input type="file" name="csv_file">
                        	</div>
                            <div class="form-group">
                                    <label>Default password</label>
                                    <input type="password" name="password" class="form-control">
                            </div>
                            <div class="form-group">
                                    <label>Confirm Default password</label>
                                    <input type="password" name="password_confirmantion" class="form-control">
                            <span> Advice employee to change password on login</span>
                            </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" value="Save">
                            <a href="{{ route('employee.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection