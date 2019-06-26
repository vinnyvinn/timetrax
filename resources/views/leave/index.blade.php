@extends('layouts.app')
@section('content')
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
        </li>
    </ul>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="{{ route('leave.create' )}}" class="btn btn-primary blue-salsa btn-circle btn-sm active">New
                        leave</a>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-2">
                            <select name="paginate" class="form-control" id="paginate">
                                <option value="15"{{ $leaves->perPage() ==15 ?  ' selected' : '' }}>15</option>
                                <option value="25"{{ $leaves->perPage() ==25 ? ' selected' : '' }} >25</option>
                                <option value="50"{{ $leaves->perPage() ==50 ? ' selected' : ''}}>50</option>
                                <option value="100"{{ $leaves->perPage() ==100 ? ' selected' : ''}}>100</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <table class="table table-striped table-hover table-responsive " id="leaves_table">
                        <thead>
                        <tr>
                            <th>Employee Name</th>
                            <th>Leave  Type</th>
                            <th>Start date</th>

                            <th>End date</th>

                            <th>Days</th>

                            <th>Status</th>
                            <th>Actions</th>


                        </tr>
                        </thead>
                        <tbody>
                        @foreach($leaves as $leave)
                            <tr>
                                <td class="text-center">{{  $leave->employee->first_name }}</td>
                                <td class="text-center">{{  $leave->leaveType->first()->leave_name }}</td>
                                <td class="text-center" id="start_date">{{ $leave->start_date->format('d F Y') }}</td>
                                <td class="text-center">{{ $leave->end_date->format('d F Y') }}</td>
                                <td class="text-center">{{ $leave->days }}</td>
                                <td class="text-center">{{ $leave->status }}</td>
                                @if($leave->status == \App\Leave::STATUS && $leave->employee_id == $employee_id && hasPermission(\App\Role::PERM_LEAVE_EDIT))
                                    <td>
                                        <a href="{{ route('leave.edit',$leave->id) }}" class="btn btn-xs btn-primary">Edit</a>
                                        <a href="#" route = "{{ route('leave.destroy', $leave->id) }}"class="btn btn-danger btn-xs delete"
                                           onclick="return confirmDelete(this)">Delete</a>
                                    </td>
                                @elseif($leave->status == \App\Leave::STATUS && hasPermission(\App\Role::PERM_LEAVE_EDIT))
                                    <td class="text-center">
                                        <a href="{{ route('leave.edit', ['id' => $leave->id, 'q' => 'pro']) }}" class="btn btn-xs btn-primary">Process</a>
                                    </td>
                                @else
                                    <td></td>
                                @endif
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
        $('#leaves_table').dataTable({
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
        (function () {
            $('#paginate').on('change', function () {
                var base = "{{ 'leave' }}";
                window.location = base + '?paginate=' + $(this).val();
            });
            $('.search').on('click', function (e) {
                e.preventDefault();
                var base = '{{ route('leave.index') }}';

                window.location = base + '?search=' + $('#search').val();
            });
        }());
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
                            swal("OOps, something went wrong");
                        }
                    });
                }

            });
        }
    </script>
@endsection
