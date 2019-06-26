@extends('layouts.app')
@section('content')
    <div class="page-head">
        <div class="page-title">
            <h1>Holidays</h1>
        </div>
    </div>
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a href="{{ url('/') }}">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{ route('holiday.index') }}">Holidays</a>
        </li>
    </ul>
    <?php $months = ['January','February','March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] ?>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="{{ route('holiday.create') }}" class="btn btn-xs btn-primary blue-salsa btn-circle btn-sm active">New holiday</a>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-2">
                            <select name="paginate" class="form-control" id="paginate">
                                <option value="10" {{ $holidays->perPage()== 10? 'selected' : ''}}>10</option>
                                <option value="20"{{ $holidays->perPage() ==20? 'selected' : '' }}>20</option>
                                <option value="30"{{ $holidays->perPage() ==30? 'selected' : '' }}>20</option>
                                <option value="0"{{ $holidays->perPage() ==0? 'selected' : '' }}>20</option>
                            </select>
                        </div>
                        <div class="col-sm-3 col-sm-offset-6">
                            <div class="input-group">
                                <input type="text" name="search" placeholder="search..." id="search" class="form-control">
                                <span class="input-group-addon">Search</span>
                            </div>
                        </div>
                    </div>

                    <table class="table table-striped table-hover table-responsive-dataTable" id="holiday_table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Day</th>
                            <th>Month</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($holidays as $holiday)
                            <tr>
                                <td><a href="{{ route('holiday.create') }}" >{{ $holiday->name }}</a></td>
                                <td>{{ $holiday->day }}</td>
                                <td>{{ $months[$holiday->month -1] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $holidays->appends([ 'paginate' => $holidays->perPage()])->render() }}
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('footer')
    <script>
        (function () {
            $('#paginate').on('change', function () {
                var base = '{{ route('employee.index') }}';

                window.location = base + '?paginate=' + $(this).val();
            });

            $('.delete').on('click', function (e) {
                e.preventDefault();

                var token = '{{ csrf_token() }}';
                var uri = $(this).attr('href');

                $.ajax(uri, {
                    'method': 'post',
                    data: {
                        '_token': token,
                        '_method': 'DELETE'
                    },
                    success: function (response) {
                        window.location = window.location;
                    },
                    error: function () {

                    }
                });
            });
        }());
    </script>
@endsection