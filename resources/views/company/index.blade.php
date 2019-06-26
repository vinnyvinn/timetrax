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
            <a href="{{ route('employee.index') }}">Company</a>
        </li>
    </ul>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="{{ route('company.create') }}"
                       class="btn btn-xs btn-primary blue-salsa btn-circle btn-sm active">New Company</a>
                </div>
                <div class="panel-body">
                    <table class="table table-responsive table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($companies as $company)
                        <tr>
                            <td>{{ $company->name }}</td>
                            <td>
                                <a href="{{ route('company.edit', $company->id) }}"
                                   class="btn btn-xs btn-primary">Edit</a>
                                <a href= "{{ route('company.destroy', $company->id) }}"
                                   class="btn btn-danger btn-xs"  data-method="delete" rel="nofollow" data-confirm="Are you sure you want to delete this?" data-token="{{ csrf_token() }}">Delete</a></td>
                        </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
        </div>
    </div>
    @endsection