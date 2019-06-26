@extends('layouts.app')
@section('content')
    <div class="container">
            <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <table class="table table-striped table-hover table-responsive-datatable" id="users_table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User name</th>
                                <th>Email</th>
                            </tr>
                            </thead>
                    <tbody>
                       @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td><a href="{{ route('user.destroy' , $user->id) }}"
                                    class="btn btn-xs btn-warning">Delete</a></td>
                            </tr>
                           @endforeach
                       </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection