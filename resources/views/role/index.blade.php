@extends('layouts.app')
@section('content')
    <div class="page-head">
        <div class="page-title">
            <h1>User Groups</h1>
        </div>
    </div>
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a href="{{ url('/') }}">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{ route('role.index') }}">user group</a>
        </li>
    </ul>
   <div class="row">
       <div class="col-sm-12">

            <div class="panel panel-default">
            <div class="panel-heading">
                <a href="{{ route('role.create') }}" class="btn btn-primary blue-salsa btn-circle btn-sm active">New user group</a>

                <button class="btn btn-primary btn-circle btn-sm " id="importFromHR">Import From HR</button>
            </div>
            <div class="panel-body">
                <table class="table table-responsive" id="role_table">
                    <thead>
                    <tr>
                        <th>User group</th>
                        <th></th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($roles as $role)
                    <tr>
                        <td>{{$role->name }}</td>
                        <td>
                          @if($role->role_status !="1")
                              <span class="label label-success"> new </span>
                          @endif
                        </td>
                        <td><a href="{{ route('role.edit', $role->id) }}" class="btn btn-xs btn-primary">Edit</a>
                            <a href="{{ route('role.destroy', $role->id) }}" class="btn btn-danger btn-xs" data-method="delete" rel="nofollow" data-confirm="Are you sure you want to delete this?" data-token="{{ csrf_token() }}">Delete</a>
                        </td>
                    </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $roles->links() }}
            </div>
        </div>
       </div>
    </div>
   </div>
    @endsection
    @section('footer')
    <script type="text/javascript">
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
                var url="designation/hr";
                $.get( url , function( data ) {
                         swal(
                              'Imported!',
                              'successfully imported groups.',
                              'success'
                            );
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