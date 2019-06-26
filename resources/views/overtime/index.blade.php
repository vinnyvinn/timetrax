@extends('layouts.app')
@section('content')
    <div class="page-head">
        <div class="page-title">
            <h1>Overtime</h1>
        </div>
    </div>
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a href="{{ url('/') }}">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{ route('overtime.index') }}">Overtime</a>
        </li>
    </ul>

    <div class="panel panel-default">
        <div class="panel-heading clearfix">
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
            </div>
            <div class="panel-body">
                <form action="{{ url('overtime') }}" method="get" class="form-horizontal">
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-6">
                            <div class="input-group input-daterange">
                                <input type="text" class="form-control date-filter" value="{{ isset($params) ? $params['from']->format('d-m-Y') : Carbon\Carbon::now()->format('d-m-Y') }}" name="from">
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
                        <table class="table table-responsive table-striped" id="overtime_table">
                            <thead>
                            <tr>
                                <th>Employee Name</th>
                                <th>Type</th>
                                <th>Hours</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($overtimes as $overtime)
                                <tr>
                                    <td class="text-center">{{ $overtime->employee->first_name }} {{$overtime->employee->last_name}}</td>
                                    <td class="text-center">{{ $overtime->overtime->name }}</td>
                                    <td class="text-center">{{ $overtime->hours }}</td>
                                    <td class="text-center">{{ Carbon\Carbon::parse($overtime->day)->format('d F Y') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endsection
        @section('footer')
            <script>
                $('.date-filter').datepicker({
                    autoclose: true,
                    format: 'dd-mm-yyyy'
                });
                $('#overtime_table').dataTable();
            </script>
@endsection