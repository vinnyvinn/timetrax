@extends('layouts.app')
@section('content')
    <div class="page-head">
        <div class="page-title">
            <h1>Company</h1>
        </div>
    </div>
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a href="{{ url('/') }}">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{ route('company.index') }}">Company</a>
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
                    <h4>Create a new company</h4>
                </div>
                <div class="panel-body">
                    <form action="{{ route('company.update', $company->id) }}" method="post" role="form">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name"
                                   placeholder="enter name of the company" value="{{ $company->name }}" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" value="Create">
                            <a href="{{ route('company.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection