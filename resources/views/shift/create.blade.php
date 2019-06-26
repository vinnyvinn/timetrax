@extends('layouts.app')
@section('content')
    <div>
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
                <a href="{{ url('shift/create') }}">Create</a>
            </li>
        </ul>
        <div class="row">
            <div class="col-sm-12">
            <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Create a new shift</h4>
            </div>
            <div class="panel-body">
                <form action="{{ route('shift.store') }}" method="post">
                    {{ csrf_field() }}
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Shift Name</label>
                            <input type="text" name="name" class="form-control" id="name" required/>
                        </div>
                        <div class="form-group">
                            <label>Shift Start</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="glyphicon glyphicon-time"></i>
                                </div>
                                <input type="text" name="shift_start" class="form-control time" id="shift_start" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Shift End</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="glyphicon glyphicon-time"></i>
                                </div>
                                <input type="text" name="shift_end" class="form-control time" id="shift_end" required />
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                       <div class="form-group">
                           <label for="name">Breaks In Minutes</label>
                           <input type="number" name="break" class="form-control" id="break" min="0" value="1" required/>
                       </div>
                        <div class="form-group">
                            <label for="day">Shift Days</label>
                            <select name="day[]" id="day" class="form-control" required multiple>
                                <option value="Monday" selected="selected">Monday</option>
                                <option value="Tuesday" selected="selected">Tuesday</option>
                                <option value="Wednesday" selected="selected">Wednesday</option>
                                <option value="Thursday" selected="selected">Thursday</option>
                                <option value="Friday" selected="selected">Friday</option>
                                <option value="Saturday" selected="selected">Saturday</option>
                                <option value="Sunday" selected="selected">Sunday</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div>
                                <input type="submit" class="btn btn-primary" value=" Save">
                                <a href="{{ route('shift.index') }}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            {{--<div class="panel-footer clearfix">--}}
            {{--<div class="col-sm-2">--}}
            {{--<a href="{{ url('settings') }}" class="btn btn-warning"><i class="fa fa-chevron-left"></i> Go back</a>--}}
            {{--</div>--}}
            {{--</div>--}}
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

            $('#breaks').on('change', function() {
                calculateDifference();
            });

            function calculateDifference()
            {
                var endTime = parseTime($('#shift_end').val());
                var startTime = parseTime($('#shift_start').val());
                var breaks = $('#break').val();

                var difference = (endTime - startTime);

            }

//            function parseTime(s) {
//                var c = s.split(':');
//                return parseInt(c[0]) * 60 + parseInt(c[1]);
//            }


//            function  calculateDifference()
//            {
//                var endTime = parseTime($('#shift_end').val());
//                var startTime = parseTime($('#shift_start').val());
//                var breaks = $('#break').val();
//            }
//            if($('#is_overnight').prop('checked'))
//            {
//                endTime = endTime + (12 * 60);
//                startTime = startTime - (12 * 60);
//            }
        }());
    </script>
@endsection
