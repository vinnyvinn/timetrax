@extends('layouts.app')
@section('content')
    <div class="page-head">
        <div class="page-title">
            <h1>Sites</h1>
        </div>
    </div>
    <ul class="breadcrumb page-breadcrumb">
        <li><a href="{{ url('/')  }}">Home</a></li>
        <i class="fa fa-circle"></i>
        <li><a href="#">Sites</a></li>
    </ul>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>View All sites</h4>
        </div>
        <div class="panel-body">
            <a href="{{ url('sites/create') }}" class="btn btn-primary">Add Sites</a>
            <table class="table table-responsive table-hover table-striped">
                <thead>
                <tr>
                    <th>
                        <div class="col-sm-3">Name</div>
                        <div class="col-sm-3">Description</div>
                        <div class="col-sm-3">Actions</div>
                        
                    </th>
                </tr>
                </thead>
                <tbody>
                    @foreach($sites as $site)
                        <tr>
                            <td>
                                <div class="col-sm-3">{{ $site->name }}</div>
                                <div class="col-sm-3">{{ $site->description }}</div>
                                <div class="col-sm-3">
                                    <a href="{{ route('sites.edit', $site->id) }}" class="btn btn-primary btn-xs">Edit</a>
                                     <a href="{{ route('sites.destroy', $site->id) }}" class="btn btn-xs btn-danger delete" data-method="delete" rel="nofollow" data-confirm="Are you sure you want to delete this?" data-token="{{ csrf_token() }}">Delete</a>
                                </div>
                               <!--  <div class="col-sm-3"></div>
                                <div class="col-sm-3"></div> -->
                            </td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
