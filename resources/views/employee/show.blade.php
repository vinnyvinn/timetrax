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
            <a href="#">View</a>
        </li>
    </ul>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="{{route('modifyCatgory',['id'=>$details->user_id])}}" class="pull-right btn btn-sm btn-success">Modify Category</a>
                    <h4>View existing Employee</h4>
                </div>
                <div class="panel-body">
                    @if(count($errors))
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </div>
                    @endif
                    <form action="{{ route('employee.update' , $details->id) }}" method="post" role="form">
                        {{  csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="payrollnumber">Payroll number</label>
                                <div class="form-control">{{ getPayrollNumberPrefix() . $details->payroll_number }}</div>
                            </div>
                            <div class="form-group">
                                <label for="firstname">First name</label>
                                <div class="form-control">{{ $details->first_name }}</div>
                            </div>
                            <div class="form-group">
                                <label for="lastname">Last name</label>
                                <div class="form-control">{{ $details->last_name }}</div>
                            </div>
                            @if($details->user)
                            <div class="form-group">
                                <label for="username">User name</label>
                                <div class="form-control">{{ $details->user->name }}</div>
                            </div>
                            @endif
                        </div>
                        <div class="col-sm-6">
                            @if($details->user)
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <div class="form-control">{{ $details->user->email }}</div>
                                </div>
                            @endif
                            @if($details->category_id == 2)
                            <div class="form-group">
                                    <label for="wage">Employee Daily Wage (KES)</label>
                                    <input type="number" class="form-control" name="wage" id="wage" placeholder="{{ $details->wage == null ? 'Not Set' : $details->wage }}" value="{{ $details->wage == null ? 'Not Set' : $details->wage }}" required disabled>
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="shift">Assigned Shifts</label>
                                <div class="form-control"></div>
                            </div>
                            @if($details->user)
                            <div class="form-group">
                                <label for="role_id">System Role</label>
                                <div class="form-control">{{ $details->user->role->name }}</div>
                            </div>
                            @endif
                            <div class="form-group">
                                <label for="company_id">Company</label>
                                <div class="form-control">{{ $details->company->name }}</div>
                            </div>
                            <div class="form-group">
                                <label for="company_id">Assigned Sites</label>
                                <div class="form-control">
                            @if($employeesites)
                                @foreach($employeesites as $emp)

                                   <a href="#" class="btn btn-primary btn-sm">
                                        @foreach($sites as $site)
                                            {{ $emp == $site->id ? $site->name : '' }}
                                        @endforeach
                                    </a>

                                @endforeach
                            @else

                            NOT SET

                            @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <a href="{{ route('employee.edit', $details->id) }}"
                               class="btn btn-primary">Edit</a>

                            <a href="{{ route('employee.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection