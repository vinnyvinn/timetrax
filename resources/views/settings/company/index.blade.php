@extends('layouts.app')
@section('content')
    <div class="page-head">
        <div class="page-title">
            <h1>Company Settings</h1>
        </div>
    </div>
    <ul class="breadcrumb page-breadcrumb">
        <li><a href="{{ url('/')  }}">Home</a></li>
        <i class="fa fa-circle"></i>
        <li><a href="#">Company Settings</a></li>
    </ul>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Set The Company settings</h4>
        </div>
        <div class="panel-body">
            <table class="table table-responsive table-hover table-striped">
                <thead>
                <tr>
                    <th>
                        <div class="col-sm-3">Policy</div>
                        <div class="col-sm-5">Description</div>
                        <div class="col-sm-2">Value</div>
                        <div class="col-sm-2">Change</div>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <div class="col-sm-3"><a href="{{ url('settings/company/min-days') }}">MINIMUM WORKING
                                DAYS</a></div>
                        <div class="col-sm-5"><p>These are the minimum working days allowed</p></div>
                        <div class="col-sm-2">
                            {{ $configs->where('setting_key', 'leave_min_working_days')->first()->setting_value == '' ? 'DISABLED' :
                             $configs->where('setting_key', 'leave_min_working_days')->first()->setting_value }}
                        </div>
                        <div class="col-sm-2"><a href="{{ url('settings/leave/min-days') }}"
                                                 class="btn btn-primary btn-xs">Change</a></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="col-sm-3"><a href="{{ url('settings/leave/rate') }}">LEAVE RATE</a></div>
                        <div class="col-sm-5"><p>This is the leave rate earned according to adherence to minimum working days</p></div>
                        <div class="col-sm-2">
                            {{ $configs->where('setting_key', 'leave_rate')->first()->setting_value == '' ? 'DISABLED' :
                             $configs->where('setting_key', 'leave_rate')->first()->setting_value }}
                        </div>
                        <div class="col-sm-2"><a href="{{ url('settings/leave/rate') }}"
                                                 class="btn btn-primary btn-xs">Change</a></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="col-sm-3"><a href="{{ url('settings/leave/accrual') }}">LEAVE ACCRUAL</a></div>
                        <div class="col-sm-5"><p>This is the accrual of leaves earned according to attendance</p></div>
                        <div class="col-sm-2">
                            {{ $configs->where('setting_key', 'leave_accrual')->first()->setting_value == '' ? 'DISABLED' :
                             ucfirst($configs->where('setting_key', 'leave_accrual')->first()->setting_value) }}
                        </div>
                        <div class="col-sm-2"><a href="{{ url('settings/leave/accrual') }}"
                                                 class="btn btn-primary btn-xs">Change</a></div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection