@extends('layouts.app')
@section('content')
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
            <a href="{{ route('shift.index') }}">Shifts</a>
        </li>
    </ul>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="{{ route('shift.create') }}" class="btn btn-xs btn-primary blue-salsa btn-circle btn-sm active">New Shift</a>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-hover table-responsive" id="employees_table">
                        <thead>
                        <tr>
                            <th>Shift Name</th>
                            <th>Shift Start</th>
                            <th>Shift End</th>
                            <th>Actions</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($shifts as $shift)
                            <tr>
                                <td><a href="{{ route('shift.show', $shift->id) }}">{{ $shift->name }}</a></td>
                                <td>{{ Carbon\Carbon::parse($shift->shift_start)->format('h:i:s a') }}</td>
                                <td>{{ Carbon\Carbon::parse ($shift->shift_end)->format('h:i:s a') }}</td>
                                <td><a href="{{ route('shift.edit', $shift->id) }}"
                                       class="btn btn-xs btn-primary">Edit</a>
                                    <a href="{{ route('shift.destroy', $shift->id) }}" class="btn btn-danger btn-xs" data-method="delete" rel="nofollow" data-confirm="Are you sure you want to delete this?" data-token="{{ csrf_token() }}">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('footer')
    <script>
        function confirmDelete(data) {
            var route = $(data).attr('route'); console.log(route);
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this information!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }, function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                        url: route,
                        type: "post",
                        data: {
                            "_method" : "DELETE",
                            "_token" : "{{ csrf_token() }}"
                        },
                        success: function(r) {
                            swal({
                                title: "Deleted",
                                type: "success",
                                text: "successfully deleted",
                                showCancelButton: false
                            }, function() {
                                location.reload(true);
                            });

                        },

                        error: function (a, b, c) {
                            swal("You cannot delete a shift with active employees");
                        }
                    });
                }

            });
        }
    </script>
    @endsection