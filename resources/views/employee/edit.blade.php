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
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="#">Edit</a>
        </li>
    </ul>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Edit existing employee</h4>
                </div>
                <div class="panel-body">
                    <form action="{{ route('employee.update' , $details->id) }}" method="post" role="form">
                        {{  csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="payrollnumber">Payroll number</label>
                                <input type="text" class="form-control" name="payroll_number" id="payroll_number" placeholder="enter payroll number" value="{{ $details->payroll_number }}" disabled="true">
                            </div>
                            <div class="form-group" >
                                <label for="firstname">First name</label>
                                <input type="text"  class="form-control" name="first_name" id="first_name" placeholder="enter first name" value="{{ $details->first_name }}" title="please enter text only">
                            </div>
                            <div class="form-group">
                                <label for="lastname">Last name</label>
                                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="enter last name" value="{{ $details->last_name }}"  title="please enter text only">
                            </div>
                             <div class="form-group">
                                <label for="id_number">ID Number</label>
                                <input type="text" class="form-control" name="id_number" id="id_nmber" placeholder="ID number"
                                value="{{ $details->id_number }}" disabled="true">
                            </div>
                            <div class="form-group">
                                <label for="id_number">Employee Type</label>
                                <select name="category_id" id="" class="form-control">
                                    <option value="1" {{ $details->category_id == 1 ? 'selected' : '' }}>Permanet Staff</option>
                                    <option value="2" {{ $details->category_id == 2 ? 'selected' : '' }}>Temporary Staff</option>
                                </select>
                            </div>

                            @if($details->user)
                                <div class="form-group">
                                    <label for="username">User name</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="enter user name" value="{{ $details->user->name }}"  title="please enter text only">
                                </div>
                            @endif
                        </div>
                        <div class="col-sm-6">
                            @if($details->user)
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" name="email" id="email" placeholder="johndoe@gmail.com" value="{{ $details->user->email }}" required>
                                </div>
                            @endif
                            @if($details->category_id == 2)
                            <div class="form-group">
                                    <label for="wage">Employee Daily Wage (KES)</label>
                                    <input type="number" class="form-control" name="wage" id="wage" placeholder="e.g 400" value="{{ $details->wage == null ? '' : $details->wage }}" required>
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="shift_id">Assigned Shifts</label>
                                <select name="shift_id" id="shift_id"  class="form-control"  required>
                                    @foreach($shifts as $shift)
                                        <option value="{{ $shift->id }}"{{ in_array($shift->id, $details->assigned_shifts) ? ' selected' : '' }}>{{ $shift->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @if($details->user)
                            <div class="form-group">
                                <label for="role_id">System Role</label>
                                <select name="role_id" id="role_id" class="form-control">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}"{{ $details->user->role_id == $role->id ? ' selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                            <div class="form-group">
                                <label for="company_id">Company</label>
                                <select name="company_id" id="company_id" class="form-control">
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}"{{ $details->company_id == $company->id ? ' selected' : '' }}>{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        <div class="form-group">
                                <label for="company_id">Assigned Sites</label>
                            @if($employeesites)
                                <div class="form-control">
                                @foreach($employeesites as $emp)

                                   <a href="#" class="btn btn-primary btn-sm">
                                        @foreach($sites as $site)
                                            {{ $emp == $site->id ? $site->name : '' }}
                                        @endforeach
                                    </a>

                                @endforeach
                                </div>
                            @else
                            
                            NOT ASSIGNED
                            @endif
                        </div>
                        @if($details->category_id != 2)
                            <div class="selectform-group">
                                <label for="sites_id">Edit Permited Sites</label>
                                <select name="sites_id[]" id="sites_id" class="form-control js-example-basic-multiple" multiple="multiple" required>
                                    @foreach($sites as $site)
                                             <option value="{{ $site->id }}">{{ $site->name }}</option>
                                        
                                    @endforeach
                                </select>
                            </div>

                        @endif
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" value="Save">

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