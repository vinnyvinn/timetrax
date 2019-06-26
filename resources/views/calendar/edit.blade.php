@extends('layouts.app')

@section('content')
    @if(Session::has('success'))
        <div class="alert alert-info col-sm-offset-1 col-sm-10">
            <strong>{{ Session::get('success') }}</strong>
        </div>
    @elseif(count($errors) > 0)
        <div class="alert alert-danger col-sm-offset-1 col-sm-10">
            <strong>{{ Session::get('success') }}</strong>
        </div>
    @endif
    <div class="page-head">
        <div class="page-title">
            <h1>Settings</h1>
        </div>
    </div>
        <ul class="breadcrumb page-breadcrumb">
            <li><a href="{{ url('/')  }}">Home</a></li>
            <i class="fa fa-circle"></i>
            <li><a href="{{ route('calendar.index') }}">Working Days</a></li>
            <i class="fa fa-circle"></i>
             <li><a href="#">Edit Working Days</a></li>
        </ul>
        <div class="panel panel-default">
            <!-- <div class="panel-heading">
                <h4>Set The System Working Days   <button class="btn btn-sm btn-warning pull-right"> Import from previous Years</button></h4>
            </div> -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <form class="form-horizontal" method="POST" action="{{ route('calendar.update' , $calendar->id) }}">
                            {{csrf_field()}}
                             {{ method_field('PUT') }}
                            <div class="form-group">
                                <label>Month</label>
                                <input type="text" class="form-control" name="month_id" value="{{ $calendar->month->month }}" disabled="true">
                               <!--  <select class="form-control" name="month">
                                        @foreach($options as $option)
                                            <option value="{{$option->id}}">{{$calendar->month_id}}</option>
                                        @endforeach
                                </select> -->
                            </div>
                            <input type="hidden" name="id" value="{{ $calendar->id }}">
                            <div class="form-group">
                                <label>No of Days</label>
                                <input type="number" name="days" class="form-control" value="{{ $calendar->days }}" max="30">
                            </div>
                            <div class="form-group">
                                    <button type="submit" class="btn btn-sm btn-success">Save</button>
                            </div>
                        </form>
                    </div>
                
                </div>
                
            </div>
        </div>
@endsection