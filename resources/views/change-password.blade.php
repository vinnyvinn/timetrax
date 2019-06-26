@extends('layouts.app')
@section('content')
    <div class="page-head">
        <div class="page-title">
            <h1>Change password</h1>
        </div>
    </div>
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a href="{{ url('/') }}">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{ route('change-password.index') }}">Change Password</a>
        </li>
        </ul>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                {{--<div class="panel-heading">--}}
                    {{--<h4>Change Password here</h4>--}}
                {{--</div>--}}
                <div class="panel-body">
                    <form action="{{ route('change-password.store') }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="password" class="form-control" name="old_password" placeholder="Confirm old password">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="New password">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm new password">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Change password">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection