@extends('layouts.app')
@section('content')
    <div class="col-sm-offset-1 col-sm-10">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="modal-title">Miscellaneous settings</h3>
            </div>
            <div class="panel-body">
                <table class="table table-hover table-striped table-bordered table-responsive">
                    <thead>
                    <tr>
                        <th>
                            <div class="col-sm-2">Policy</div>
                            <div class="col-sm-8">Description</div>
                            <div class="col-sm-1">Value</div>
                            <div class="col-sm-1">Change</div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <div class="col-sm-2"><a href="{{ url('settings/misc/multiple-checkins') }}">MULTIPLE CHECK-INS</a></div>
                            <div class="col-sm-8"><p>This controls the number of check-ins allowed daily</p></div>
                            <div class="col-sm-1">
                                {{ $configs->where('setting_key', 'multiple_checkins')->first()->setting_value == '' ? 'NOT SET' :
                                 $configs->where('setting_key', 'multiple_checkins')->first()->setting_value }}
                            </div>
                            <div class="col-sm-1"><a href="{{ url('settings/misc/multiple-checkins') }}" class="btn btn-primary btn-xs">Change</a></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="col-sm-2"><a href="{{ url('settings/misc/undertime') }}">UNDERTIME</a></div>
                            <div class="col-sm-8"><p>This handles the time less the required clocked</p></div>
                            <div class="col-sm-1">
                                {{ $configs->where('setting_key', 'undertime')->first()->setting_value == '' ? 'NOT SET' :
                                 $configs->where('setting_key', 'undertime')->first()->setting_value }}
                            </div>
                            <div class="col-sm-1"><a href="{{ url('settings/misc/undertime') }}" class="btn btn-primary btn-xs">Change</a></div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection