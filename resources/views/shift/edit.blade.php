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
                <a href="{{ url('shift') }}">Edit</a>
            </li>
        </ul>
        <div class="panel panel-default">
            <div class="panel-heading">
                Edit existing shift
            </div>
            <div class="panel-body">

                <form action="{{ route('shift.update', $shift->id) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="form-group">
                        <label for="name">Shift Name</label>
                        <input type="text" name="name" class="form-control" id="name" required value="{{ $shift->name }}">
                    </div>
                    <div class="form-group">
                        <label for="shift_start">Shift Start</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-time"></i>
                            </div>
                            <input type="text" name="shift_start" class="form-control time" id="shift_start" required value="{{ $shift->shift_start }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="shift_start">Shift End</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-time"></i>
                            </div>
                            <input type="text" name="shift_end" class="form-control time" id="shift_end" required value="{{ $shift->shift_end }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="shift_start">Breaks In Minutes</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-time"></i>
                            </div>
                            <input type="number" name="break" class="form-control break" id="break" required value="{{ $shift->break }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="day">Shift Days</label>
                        <select name="day[]" id="day" class="form-control" required multiple>
                            <option value="Monday"{{ in_array('Monday', $shift->day) ? ' selected' : '' }}>Monday</option>
                            <option value="Tuesday"{{ in_array('Tuesday', $shift->day) ? ' selected' : '' }}>Tuesday</option>
                            <option value="Wednesday"{{ in_array('Wednesday', $shift->day) ? ' selected' : '' }}>Wednesday</option>
                            <option value="Thursday"{{ in_array('Thursday', $shift->day) ? ' selected' : '' }}>Thursday</option>
                            <option value="Friday"{{ in_array('Friday', $shift->day) ? ' selected' : '' }}>Friday</option>
                            <option value="Saturday"{{ in_array('Saturday', $shift->day) ? ' selected' : '' }}>Saturday</option>
                            <option value="Sunday"{{ in_array('Sunday', $shift->day) ? ' selected' : '' }}>Sunday</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value=" Save">
                        <a href="{{ route('shift.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
@section('footer')
    <script>
        (function () {
            $('.time').timepicker({
                minuteStep: 5,
                showInputs: false,
                disableFocus: true
            });
            $('#day').select2();
        }());
    </script>
@endsection
