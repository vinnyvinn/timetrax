@extends('layouts.app')
@section('content')
    <div class="col-sm-12">
        <h3>General Attendance</h3>
    </div>
    <div class="col-sm-8 col-sm-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <div class="col-sm-4">
                    <select name="id" id="attendance-employees" class="form-control">
                        <option value="" selected></option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->first_name." ".$employee->last_name }}</option>
                        @endforeach
                        {{--<option value="1">one</option>--}}
                        {{--<option value="2">two</option>--}}
                    </select>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Day</th>
                            <th>Time in</th>
                            <th>Time out</th>
                            <th>Time difference</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="row in attendances">
                            <td>@{{ row.day }}</td>
                            <td>@{{ row.time_in }}</td>
                            <td>@{{ row.time_out }}</td>
                            <td>@{{ row.time_taken }}</td>
                        </tr>
                        <tr v-if="attendances.length < 1">
                            <td colspan="4" style="text-align: center">No attendances registered yet</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{--<div class="col-sm-offset-1 col-sm-10">--}}
        {{--<form action="/register" method="post" class="form-horizontal">--}}
            {{--{{ csrf_field() }}--}}
            {{--<div class="form-group">--}}
                {{--<div class="col-sm-6 col-sm-offset-1">--}}
                    {{--<select name="id" id="employee" class="form-control">--}}
                        {{--@foreach($employees as $employee => $name)--}}
                            {{--<option value="{{ $name['id'] }}" data-attendance="{{ implode('', $name['attendance']) }}">{{ $name['name'] }}</option>--}}
                        {{--@endforeach--}}
                    {{--</select>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="form-group">--}}
                {{--<div class="col-sm-4 col-sm-offset-1">--}}
                    {{--<button type="submit" id="for-check-in" class="btn btn-lg"></button>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</form>--}}
    {{--</div>--}}
@endsection
