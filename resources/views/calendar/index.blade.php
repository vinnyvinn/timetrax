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
            <li><a href="#">Working Days</a></li>
        </ul>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Set The System Working Days   <button class="btn btn-sm btn-warning pull-right"> Import from previous Years</button></h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4 col-md-offset-1">
                        <form class="form-horizontal" method="POST" action="{{url('calendar')}}">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label>Month</label>
                                <select class="form-control" name="month">
                                        @foreach($options as $option)
                                            <option value="{{$option->id}}">{{$option->month}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>No of Days</label>
                                <input type="number" name="days" class="form-control" max="31">
                            </div>
                            <div class="form-group">
                                    <button class="btn btn-sm btn-success">Add</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                         <table class="table table-hover table-striped table-responsive">
                            <thead>
                                <th>Month</th>
                                <th>Working Days</th>
                                <th>Workng Year</th>
                                <th>Created at</th>
                                <th>#</th>
                            </thead>
                            <tbody>
                                @foreach($calendars as $calendar)
                                <tr>
                                    <td>{{$calendar->month->month}}</td>
                                    <td>{{$calendar->days}}</td>
                                    <td>{{$calendar->year}}</td>
                                    <td> <label class="label label-success">{{date('Y-M-d',strtotime($calendar->created_at))}}</label></td>
                                    <td>
                                        <a href="{{ route('calendar.edit', $calendar->id)}}" class="btn btn-sm btn-primary fa fa-pencil"></a>
                                        <!-- <button class="btn  btn-sm btn-primary fa fa-pencil"></button> -->
                                        <a href="{{ route('calendar.destroy', $calendar->id) }}" class="btn btn-sm btn-danger delete fa fa-trash" data-method="delete" rel="nofollow" data-confirm="Are you sure you want to delete this?" data-token="{{ csrf_token() }}"></a>
                                    </td>
                                </tr>

                                @endforeach
                            </tbody>
                          </table>
                    </div>
                </div>
                
            </div>
        </div>
@endsection