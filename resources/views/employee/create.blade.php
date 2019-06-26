@extends('layouts.app')
@section('content')
<div>
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
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{ route('employee.create') }}">Create</a>
        </li>
    </ul>
</div>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Create a new employee</h4>
                </div>
                <div class="panel-body">
                    <form action="{{ route('employee.store') }}" method="post" role="form">
                        {{  csrf_field() }}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="payrollnumber">Payroll number</label>
                                <input type="text" class="form-control" name="payroll_number" id="payroll_number"
                                       placeholder="enter payroll number" value="{{ old('payroll_number') }}">
                            </div>
                            <div class="form-group">
                                <label for="firstname">First name</label>
                                <input type="text" class="form-control" name="first_name" id="first_name"
                                       placeholder="enter first name" value="{{ old('first_name') }}" pattern="([a-zA-Z]+$)"
                                       title="please enter text only">
                            </div>
                            <div class="form-group">
                                <label for="id_number">ID Number</label>
                                <input type="text" class="form-control" name="id_number" id="id_nmber" placeholder="ID number"
                                value="{{ old('id_number') }}">
                            </div>
                            <div class="form-group">
                                <label for="lastname">Last name</label>
                                <input type="text" class="form-control" name="last_name" id="last_name"
                                       placeholder="enter last name" value="{{ old('last_name') }}" pattern="([a-zA-Z]+$)"
                                       title="please enter text only">
                            </div>
                            <div class="form-group">
                                <label for="username">User name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="enter user name"
                                       value="{{ old('name') }}" pattern="([a-zA-Z]+$)" title="please enter text only">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email"
                                       placeholder="johndoe@gmail.com" value="{{ old('email') }}">
                            </div>
                            <div class="form-group">
                                <label for="shift_id">Assigned Shifts</label>
                                <select name="shift_id" id="shift_id" class="form-control" required>
                                    @foreach($shifts as $shift)
                                        <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="role_id">System Role</label>
                                <select name="role_id" id="role_id" class="form-control">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="selectform-group">
                                <label for="company_id">Company</label>
                                <select name="company_id" id="company_id" class="form-control">
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="selectform-group">
                                <label for="sites_id">Permit Sites</label>
                                <select name="sites_id[]" id="sites_id" class="form-control js-example-basic-multiple" multiple="multiple" required>
                                    @foreach($sites as $site)
                                        <option value="{{ $site->id }}">{{ $site->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" value="Create">
                            <a href="{{ route('employee.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });

    </script>


@endsection