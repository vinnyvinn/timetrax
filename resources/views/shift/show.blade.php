@extends('layouts.app')
@section('content')
    <div class="col-sm-offset-2 col-sm-8">
        <div class="page-head">
            <div class="page-title">
                <h1>Shifts</h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ url('shift') }}">Shifts</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ url('shift/show') }}">Show</a>
            </li>
        </ul>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Show existing shift</h4>
            </div>
            <div class="panel-body">

                <form action="{{ route('shift.update', $shift->id) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="form-group">
                        <label for="name">Shift Name</label>
                        <h4>{{ $shift->name }}</h4>
                    </div>
                    <div class="form-group">
                        <label for="shift_start">Shift Start</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-time"></i>
                            </div>
                            <h4> {{ $shift->shift_start }}</h4>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="shift_start">Shift End</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-time"></i>
                            </div>
                            <h4>{{ $shift->shift_end }}</h4>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="day">Shift Days</label>
                       <h4>{{ implode(', ', $shift->day) }}</h4>
                    </div>
                    <div class="form-group">
                        <a href="{{ route('shift.edit', $shift->id) }}"
                           class="btn btn-primary">Edit</a>
                        <a href="{{ route('shift.index') }}" class="btn btn-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
{{--@section('footer')--}}
    {{--<script>--}}
        {{--(function () {--}}
            {{--$('.time').timepicker({--}}
                {{--minuteStep: 5,--}}
                {{--showInputs: false,--}}
                {{--disableFocus: true--}}
            {{--});--}}
            {{--$('#day').select2();--}}
        {{--}());--}}
    {{--</script>--}}
{{--@endsection--}}
