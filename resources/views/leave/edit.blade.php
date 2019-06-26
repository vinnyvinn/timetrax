@extends('layouts.app')
@section('content')
    <div class="col-sm-offset-2 col-sm-8">
    <div class="page-head">
        <div class="page-title">
            <h1>Leaves</h1>
        </div>
    </div>
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a href="{{ url('/') }}">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{ route('leave.index') }}">Leaves</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="#">Edit</a>
        </li>
    </ul>
 </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default col-sm-8 col-sm-offset-2">
                <div class="panel-heading">
                    Set new Leave
                </div>
                <div class="panel-body">
                    @if(count($errors))
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </div>
                    @endif
                    <form action="{{ route('leave.update' , $details->id) }}" method="post" role="form">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group">
                            <label for="employee_id">Employee</label>
                            <select class="form-control"{{ $processing ? ' disabled': '' }} name="employee_id" id="employee_id" required>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}"{{ $details->employee_id == $employee->id ? ' selected' : '' }}>{{ getPayrollNumberPrefix() . $employee->payroll_number }}-{{ $employee->first_name }} {{ $employee->last_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="start_date">Leave Start</label>
                            <input type="text"{{ $processing ? ' disabled': '' }} class="form-control" id="start_date" name="start_date" value="{{ $details->start_date  }}" required>
                        </div>

                        <div class="form-group">
                            <label for="end_date">Leave End</label>
                            <input type="text"{{ $processing ? ' disabled': '' }} class="form-control" id="end_date" name="end_date" value="{{ $details->end_date }}" required>
                        </div>

                        @if($processing)
                            <div class="form-group">
                                <label for="employee_id">Status</label>
                                <select class="form-control" name="status" id="status" required>
                                    <option value="{{ \App\Leave::DECLINED }}"{{$details->status == \App\Leave::DECLINED ? 'selected' : ''}}>Decline Request</option>
                                    <option value="{{ \App\Leave::APPROVED }}"{{$details->status == \App\Leave::APPROVED ? 'selected' : ''}}>Approve Request</option>
                                </select>
                            </div>
                        @endif

                        <div class="form-group">
                            <button class="btn btn-success" type="submit">
                                {{ $processing ? 'Complete Review' : 'Save Changes' }}
                            </button>
                            <a href="{{ route('leave.index') }}" class="btn btn-danger">Cancel</a>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        $('select').select2();

        $('#end_date').datepicker({
            autoclose: true,
            format: 'yyyy-m-d',
            startDate: '0d'
        });

        $('#start_date').datepicker({
            autoclose: true,
            format: 'yyyy-m-d',
            startDate: '0d'
        }).on('changeDate', function (e) {
            $('#end_date').datepicker('setStartDate', e.date);
        });


    </script>
@endsection