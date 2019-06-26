@extends('layouts.app')
@section('content')
    <h1>Create a holiday</h1>
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a href="{{url('/')  }}">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{ route('holiday.index') }}">Holiday</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{ route('holiday.create') }}">Create</a>
        </li>
    </ul>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="calendar"></div>
            <div class="form-group form-md-line-input form-md-floating-label">
            </div>
            <div class="modal fade bs-modal-sm " id="add_holiday" role="dialog" aria-hidden="true"
                 style="position: fixed; top: 30% !important;">
                <div class="modal-dialog  modal-sm">
                    <form action="{{ route('holiday.store') }}" method="post" role="form">
                        {{ csrf_field() }}
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal title">Holiday details</h4>
                            </div>
                            <div class="modal-body">
                                <label for="holiday_name">Holiday Name</label>
                                <input type="text" name="holiday" id="holiday_name" class="form-control" required>
                                <input type="hidden" name="holiday_day" id="holiday_day" class="form-control">
                                <input type="hidden" name="holiday_month" id="holiday_month" class="form-control">
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" id="save_holiday"><a
                                                href="{{ route('holiday.index') }}"></a> Save
                                    </button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        $(document).ready(function () {
            $(' .calendar').fullCalendar({
                header: {
                    left: 'prev, next today',
                    center: 'title',
                    right: 'month, basicWeek'
                },
                defaultDate: {{ date('Y') }}+'-01-01',
                editable: true,
                eventLImit: true,

                events: [
                        @foreach($holidays as $holiday)
                    {
                        allDay: true,
                        id: '{{ $holiday->id }}',
                        title: "{!! $holiday->name !!}",
                        start: '{{ Carbon\Carbon::now()->year . '-' . $holiday->month . '-' . $holiday->day }}'
                    },
                    @endforeach
                ],
                dayClick: function (date, jsEvent, view) {
                    var eventDate = date.format();
                    var parts = eventDate.split('-');
                    var eMonth = parts[1];
                    var eDate = parts[2];

                    $('#holiday_day').val(eDate);
                    $('#holiday_month').val(eMonth);
                    $('#add_holiday').modal('show');
                }
            });
            $('.fc-day').on('hover', function () {
                $('.fc-day').html('');
                $(this).html('<br><p style="padding:10px;">click to<br> add_holiday</p>');
            });
        });
    </script>
@endsection