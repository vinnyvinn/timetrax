@extends('layouts.app')

@section('content')
    @if(Session::has('success'))
        <div class="alert alert-info col-sm-offset-1 col-sm-10">
            <strong>{{ Session::get('success') }}</strong>
        </div>
    @elseif(count($errors) > 0)
        <div class="alert alert-danger col-sm-offset-1 col-sm-10">
            <strong>{{ Session::get('success') }}</strong>
        </div>
    @endif
    <div class="page-head">
        <div class="page-title">
            <h1>Settings</h1>
        </div>
    </div>
        <ul class="breadcrumb page-breadcrumb">
            <li><a href="{{ url('/')  }}">Home</a></li>
            <i class="fa fa-circle"></i>
            <li><a href="#">Settings</a></li>
        </ul>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Set The System Settings</h4>
            </div>
            <div class="panel-body">
                <table class="table table-hover table-striped table-responsive">
                    <thead>
                    <tr>`
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
                            <div class="col-sm-3"><a href="{{ url('settings/overtime') }}">OVERTIME</a></div>
                            <div class="col-sm-5"><p>This enables or disables overtime calculation</p></div>
                            <div class="col-sm-2">
                                {{ $configs->where('setting_key', 'overtime')->first()->setting_value == '' ? 'DISABLED' :
                                 ucfirst($configs->where('setting_key', 'overtime')->first()->setting_value) }}
                            </div>
                            <div class="col-sm-2"><a href="{{ url('settings/overtime') }}"
                                                     class="btn btn-primary btn-xs">Change</a></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <!-- <div class="col-sm-3"><a href="{{ url('settings/leave') }}">LEAVE</a></div>
                            <div class="col-sm-5"><p>This determines if the leave page will be displayed or not</p></div>
                            <div class="col-sm-2">
                                {{ $configs->where('setting_key', 'leave')->first()->setting_value == '' ? 'DISABLED' :
                                 ucfirst($configs->where('setting_key', 'leave')->first()->setting_value) }}
                            </div>
                            <div class="col-sm-2"><a href="{{ url('settings/leave') }}" class="btn btn-primary btn-xs">Change</a>
                            </div> -->
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="col-sm-3"><a href="{{ url('settings/misc/multiple-checkins') }}">MULTIPLE
                                    CHECK-INS</a></div>
                            <div class="col-sm-5"><p>This determines the number of check-ins in a day</p></div>
                            <div class="col-sm-2">
                                {{ $configs->where('setting_key', 'multiple_checkins')->first()->setting_value == '' ? 'DISABLED' :
                                 ucfirst($configs->where('setting_key', 'multiple_checkins')->first()->setting_value) }}
                            </div>
                            <div class="col-sm-2"><a href="{{ url('settings/misc/multiple-checkins') }}"
                                                     class="btn btn-primary btn-xs">Change</a></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="col-sm-3"><a href="{{ url('settings/misc/undertime') }}">UNDERTIME</a></div>
                            <div class="col-sm-5"><p>This enables or disables undertime determination</p></div>
                            <div class="col-sm-2">
                                {{ $configs->where('setting_key', 'undertime')->first()->setting_value == '' ? 'DISABLED' :
                                 ucfirst($configs->where('setting_key', 'undertime')->first()->setting_value) }}
                            </div>
                            <div class="col-sm-2"><a href="{{ url('settings/misc/undertime') }}"
                                                     class="btn btn-primary btn-xs">Change</a></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="col-sm-3"><a href="{{ url('settings/prefix-settings') }}">PAYROLL NUMBER PREFIX</a></div>
                            <div class="col-sm-5"><p>This is the payroll NUMBER prefix</p></div>
                            <div class="col-sm-2">
                                {{ $configs->where('setting_key', 'payroll_number_prefix')->first()->setting_value == '' ? 'DISABLED' :
                                 ucfirst($configs->where('setting_key', 'payroll_number_prefix')->first()->setting_value) }}
                            </div>
                            <div class="col-sm-2"><a href="{{ url('settings/prefix-settings') }}"
                                                     class="btn btn-primary btn-xs">Change</a></div>
                        </td>    
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
@endsection