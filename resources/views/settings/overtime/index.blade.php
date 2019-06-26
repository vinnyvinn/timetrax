@extends('layouts.app')
@section('content')
    <div class="page-head">
        <div class="page-title">
            <h1>Overtime Settings</h1>
        </div>
    </div>
    <ul class="breadcrumb page-breadcrumb">
        <li><a href="{{ url('/')  }}">Home</a></li>
        <i class="fa fa-circle"></i>

        <li><a href="{{ route('overtime.index') }}">Overtime</a></li>
        <i class="fa fa-circle"></i>

        <li><a href="#">Overtime Settings</a></li>
    </ul>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Set The Overtime settings</h4>
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
                            <div class="col-sm-3"><a href="{{ url('settings/overtime/standard-type') }}">OVERTIME
                                    STANDARD TYPE</a></div>
                            <div class="col-sm-5"><p>Determines the calculation of overtime</p></div>
                            <div class="col-sm-2">
                                {{ $configs->where('name', 'Standard Overtime')->first()->type }}
                            </div>
                            <div class="col-sm-2"><a href="{{ url('settings/overtime/standard-type') }}"
                                                     class="btn btn-primary btn-xs">Change</a></div>
                        </td>
                    </tr>
                    @if($configs->where('name', 'Standard Overtime')->first()->type == 'Rate')
                        <tr>
                            <td>
                                <div class="col-sm-3"><a href="{{ url('settings/overtime/standard-rate') }}">OVERTIME
                                        STANDARD RATE</a></div>
                                <div class="col-sm-5"><p>This is the rate at at which overtime will be calculated</p></div>
                                <div class="col-sm-2">
                                    {{ $configs->where('name', 'Standard Overtime')->first()->rate }}
                                </div>
                                <div class="col-sm-2"><a href="{{ url('settings/overtime/standard-rate') }}"
                                                         class="btn btn-primary btn-xs">Change</a></div>
                            </td>
                        </tr>
                    @elseif($configs->where('name', 'Standard Overtime')->first()->type == 'Slab')
                        <tr>
                            <td>
                                <div class="col-sm-3"><a href="{{ url('settings/overtime/standard-slabs') }}">STANDARD
                                        SLABS</a></div>
                                <div class="col-sm-5"><p>This displays the slabs created</p></div>
                                <div class="col-sm-2">
                                    {{ $configs->where('name', 'Standard Overtime')->first()->slabs->count() . ' slabs' }}
                                </div>
                                <div class="col-sm-2"><a href="{{ url('settings/overtime/standard-slabs') }}"
                                                         class="btn btn-primary btn-xs">Change</a></div>
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td>
                            <div class="col-sm-3"><a href="{{ url('settings/overtime/special-type') }}">OVERTIME SPECIAL
                                    TYPE</a></div>
                            <div class="col-sm-5"><p>This determines on what the overtime calculation will be based on</p></div>
                            <div class="col-sm-2">
                                {{ $configs->where('name', 'Special Overtime')->first()->type }}
                            </div>
                            <div class="col-sm-2"><a href="{{ url('settings/overtime/special-type') }}"
                                                     class="btn btn-primary btn-xs">Change</a></div>
                        </td>
                    </tr>
                    @if($configs->where('name', 'Special Overtime')->first()->type == 'Rate')
                        <tr>
                            <td>
                                <div class="col-sm-3"><a href="{{ url('settings/overtime/special-rate') }}">OVERTIME
                                        SPECIAL RATE</a></div>
                                <div class="col-sm-5"><p>This is the rate at which overtime is calculated</p></div>
                                <div class="col-sm-2">
                                    {{ $configs->where('name', 'Special Overtime')->first()->rate }}
                                </div>
                                <div class="col-sm-2"><a href="{{ url('settings/overtime/special-rate') }}"
                                                         class="btn btn-primary btn-xs">Change</a></div>
                            </td>
                        </tr>
                    @elseif($configs->where('name', 'Special Overtime')->first()->type == 'Slab')
                        <tr>
                            <td>
                                <div class="col-sm-3"><a href="{{ url('settings/overtime/special-slabs') }}">SPECIAL
                                        SLABS</a></div>
                                <div class="col-sm-5"><p>This displays the special slabs created</p></div>
                                <div class="col-sm-2">
                                    {{ $configs->where('name', 'Special Overtime')->first()->slabs->count() . ' slabs' }}
                                </div>
                                <div class="col-sm-2"><a href="{{ url('settings/overtime/special-slabs') }}"
                                                         class="btn btn-primary btn-xs">Change</a></div>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
@endsection