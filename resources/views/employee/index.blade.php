@extends('layouts.app')
@section('content')
    <div class="page-head">
        <div class="page-title">
            <h1>Employees</h1>
        </div>
    </div>
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a href="{{ url('/') }}">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{ route('employee.index') }}">Employees</a>
        </li>
    </ul>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="{{ route('employee.create') }}"
                       class="btn btn-xs btn-primary blue-salsa btn-circle btn-sm active">New Employee</a>
                    <a href="{{ route('import') }}"
                       class="btn btn-xs btn-primary blue-salsa btn-circle btn-sm active">Import CSV
                    </a>

                    <button id="importFromHR"
                       class="btn btn-xs btn-primary blue-salsa btn-circle btn-sm active">Import From HR 
                    </button>
                </div>
                <div class="panel-body">
                    @if(count($errors))
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </div>
                    @endif
                    {{--<div class="row">--}}
                        {{--<div class="col-sm-2">--}}
                            {{--<select name="paginate" id="paginate" class="form-control">--}}
                                {{--<option value="15"{{ $employees->perPage() == 15? ' selected' : '' }}>15</option>--}}
                                {{--<option value="25"{{ $employees->perPage() == 25? ' selected' : '' }}>25</option>--}}
                                {{--<option value="50"{{ $employees->perPage() == 50? ' selected' : '' }}>50</option>--}}
                                {{--<option value="100"{{ $employees->perPage() == 100? ' selected' : '' }}>100</option>--}}
                                {{--<option value="100000000"{{ $employees->perPage() == 0 ? ' selected' : '' }}>Show All--}}
                                {{--</option>--}}
                            {{--</select>--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-3 col-sm-offset-6">--}}
                            {{--<div class="input-group">--}}
                                {{--<div class="input-cont">--}}
                                    {{--<input type="search" class="form-control" id="search" name="search"--}}
                                           {{--placeholder="Search..." class="form-control">--}}
                                {{--</div>--}}
                                {{--<span class="input-group-btn">--}}
                                    {{--<button type="button" class="btn green-haze search ">--}}
                                    {{--Search &nbsp; <i class="m-icon-swapright m-icon-white"></i>--}}
                                    {{--</button>--}}
                                {{--</span>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<hr>--}}
                    <table class="table table-striped table-condensed flip-content" id="employees_table">
                        <thead class="flip-content">
                        <tr>
                            <th>Payroll number</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Employee Type</th>
                            <th class="hidden-print">Actions</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($employees as $employee)
                            <tr>
                                <td class="text-center">
                                    <a href="{{ route('employee.show', $employee->id) }}">{{ getPayrollNumberPrefix() . $employee->payroll_number}}</a>
                                </td>
                                <td class="text-center">{{$employee->first_name}} {{$employee->last_name}}</td>
                                @if($employee->user)
                                <td class="text-center">{{ $employee->user->email }}</td>
                                @else
                                    <td></td>
                                @endif
                                <td class="text-center">{{ $employee->category_id == 1 ? 'Permanent Staff' : 'Temporary Staff' }}</td>
                                <td class="hidden-print text-center">
                                    <a href="{{ route('employee.edit', $employee->id) }}"
                                       class="btn btn-xs btn-primary">Edit</a>
                                    <a href="{{ route('employee.destroy', $employee->id) }}" class="btn btn-xs btn-danger delete" data-method="delete" rel="nofollow" data-confirm="Are you sure you want to delete this?" data-token="{{ csrf_token() }}">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $employees->appends(['paginate' => $employees->perPage()])->render() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>

    $(function(){
        $('#importFromHR').click(function(){
            swal({
              title: 'Import From HRmaster?',
              text: "You won't be able to revert this!",
              type: 'info',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, Import it!',
              cancelButtonText: 'No, cancel!',
              confirmButtonClass: 'btn btn-success',
              cancelButtonClass: 'btn btn-danger',
              buttonsStyling: false,
              reverseButtons: true
            }).then((result) => {
              if (result.value) {
                var url="employee/hr";
                $.get( url , function( data ) {
                         swal(
                              'Imported!',
                              'Your file has been deleted.',
                              'success'
                            ), function() {
                            alert();
                                location.reload(true);
                            };
                  });
            
              } else if (result.dismiss === 'cancel') {
                swal(
                  'Dropped',
                  'Request has been dropped',
                  'error'
                )
              }
            })
         });
    });
        $('#employees_table').dataTable({
            dom: 'Bfrtip',
            buttons: [
               'colvis',
                {
                    extend: 'print',
                    exportOptions: {
                        columns: ':visible'
                    }
                }
            ]
        });
        {{--(function () {--}}
            {{--$('#paginate').on('change', function () {--}}
                {{--var base = '{{ route('employee.index') }}';--}}

                {{--window.location = base + '?paginate=' + $(this).val();--}}
            {{--});--}}

            {{--$('.search').on('click', function (e) {--}}
                {{--e.preventDefault();--}}
                {{--var base = '{{ route('employee.index') }}';--}}

                {{--window.location = base + '?search=' + $('#search').val();--}}
            {{--});--}}

            {{--$('#search').on('keyup', function (e) {--}}
                {{--if (e.keyCode == 13)--}}
                {{--{--}}
                    {{--var base = '{{ route('employee.index') }}';--}}

                    {{--window.location = base + '?search=' + $('#search').val();--}}
                {{--}--}}

            {{--});--}}

        {{--}());--}}


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
                                showCancelButton: false,

                            }, function() {
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