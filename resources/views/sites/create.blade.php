@extends('layouts.app')
@section('content')
    <h1>Create a Site</h1>
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a href="{{url('/')  }}">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{ route('sites.index') }}">Sites</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{ route('holiday.create') }}">Create</a>
        </li>
    </ul>
    <div class="panel panel-default">
        <div class="panel-body">
            <form action="{{ route('sites.store')}}" method="post">
                {{ csrf_field() }}
                  <div class="col-sm-6>
                            <div class="form-group">
                                <label for="payrollnumber"> Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                       placeholder="enter  name" value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="text" name="description" class="form-control" id="description" placeholder="Enter description">
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div> 
                 </div>
                 <div class="col-sm-6">
                    <div id="somecomponent" style="width: 400px; height: 400px;"></div>
                        <script>
                            $('#somecomponent').locationpicker();
                        </script>
                     </div>
                </div>
            </form>
        </div>
    </div>
@endsection