@extends('layouts.app')
@section('content')
    <div class="page-head">
        <div class="page-title">
            <h1>Leave Settings</h1>
        </div>
    </div>
    <ul class="breadcrumb page-breadcrumb">
        <li><a href="{{ url('/')  }}">Home</a></li>
        <i class="fa fa-circle"></i>
        <li><a href="#">Leave Settings</a></li>
    </ul>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Leave Categories</h4>
                <button class="btn btn-sm btn-success" id="importLeaves">Import From HR</button>
            </div>
            <div class="panel-body">
                <table class="table table-responsive table-hover table-striped">
                    <thead>
                    <tr>
                        <th>
                            <div class="col-sm-3">Leave Name</div>
                        </th>
                        <th>
                            <div class="col-sm-5">Leave alias</div>
                        </th>
                        <th>
                            <div class="col-sm-2">created_at</div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($leaves as $leave)
                    <tr>
                        <td>
                                {{$leave->leave_name}}
                        </td> 
                        <td>
                                {{$leave->leave_alias}}

                        </td> 
                        <td>
                                {{date('Y-M-d',strtotime($leave->created_at))}}

                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
@endsection
@section('footer')

        <script type="text/javascript">
        $(function(){
            $('#importLeaves').click(function(){
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
                var url='leave-importHR';
                $.get( url , function( data ) {
                    console.log(data);
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
        </script>
@endsection