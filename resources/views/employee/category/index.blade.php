@extends('layouts.app')
@section('content')
<div>
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
            <a href="{{ route('employee.create') }}">Categories</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
             <h4 class="pull-right"><label class="label label-primary"> Import From HR</label></h4>
                <h4>Create Catgory</h4>
               
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3">
                         <div class="form-group">
                            <label>Category Name</label>
                            <input type="text" name="category" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h4 class="label label-success"> Set Default permissions</h4>

                        
                    </div>
                </div>
               
            </div>
        </div>
    </div>
</div>

@endsection