@extends('layouts.app')
@section('content')
    <div class="page-head">
        <div class="page-title">
            <h1>Attendances - <small> Check in or out</small></h1>
        </div>
    </div>
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a href="{{ url('/') }}">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{ route('attendance.index') }}">Attendances</a>
        </li>
    </ul>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <div class="row">
                        <div class="col-sm-6">
                            @if(isset($params))
                                <h4>
                                    Attendances From
                                    <strong>{{ $params['from']->format('d F Y') }}</strong> To
                                    <strong>{{ $params['to']->format('d F Y') }}</strong>
                                </h4>
                            @else
                                <h4>Attendances For {{ \Carbon\Carbon::now()->format('d F Y') }}</h4>
                            @endif
                        </div>
                        <div class="col-sm-6">
                            @if(hasPermission(App\Role::PERM_VIEW_ATTENDANCE_BUTTON))
                            <div class="pull-right">
                                <!-- <a href="{{ route('attendance.create') }}" class="btn btn-primary">Bulk Assign Attendance</a> -->
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <form action="{{ url('attendance') }}" method="get" class="form-horizontal">
                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-6">
                                <div class="input-group input-daterange">
                                    <input type="text" class="form-control date-filter" value="{{ isset($params) ? $params['from']->format('d-m-Y') : Carbon\Carbon::now()->subDays(1)->format('d-m-Y') }}" name="from">
                                    <div class="input-group-addon">to</div>
                                    <input type="text" class="form-control date-filter" value="{{ isset($params) ? $params['to']->format('d-m-Y') : Carbon\Carbon::now()->format('d-m-Y')  }}" name="to">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-default pull-right"><span class="glyphicon glyphicon-search"></span> Filter</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <table class=" table stripe table-hover table-responsive-dataTable" id="attendance_table">
                        <thead>
                        <tr>
                            <th>Employee name</th>
                            <th>Site Name</th>
                            <th>Check in</th>
                            <th>Check out</th>
                            <th>Clocked Hours</th>
                            <th>Overtime Hours</th>
                            <th>Day</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($attendances as $attendance)
                            <tr>
                                <td>{{ $attendance->employee->first_name }} {{ $attendance->employee->last_name }}</td>
                                <td>{{ $attendance->site->name }}</td>
                                <td>{{ Carbon\Carbon::parse($attendance->time_in)->format('h:i:s a') }}</td>
                                <td>{{ $attendance->time_out ? Carbon\Carbon::parse($attendance->time_out)->format('h:i:s a') : 'Not Checked Out' }}</td>
                                <td class="text-center">{{ number_format((($attendance->clocked_minutes )/60), 2) }}</td>
                                <td class="text-center">{{ number_format((($attendance->overtime_minutes)/ 60), 2) }}</td>
                                <td>{{ Carbon\Carbon::parse($attendance->day)->format('d F Y') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
{{--                    {{ $attendances->links() }}--}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
	<script>
		$('#attendance_table').dataTable({
		    paginate: false,
            order: [[3, "asc"]],
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel', 'pdf','colvis',
                {
                    extend: 'print',
                    exportOptions: {
                        columns: ':visible'
                    }
                }
            ]
        });
        $('.date-filter').datepicker({
            autoclose: true,
            endDate: '0d',
            format: 'dd-mm-yyyy'
        });
	</script>
@endsection
