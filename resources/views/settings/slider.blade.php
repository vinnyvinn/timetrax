@extends('layouts.app')
@section('content')
    <div class="col-sm-offset-2 col-sm-8">
        <div class="page-head">
            <div class="page-title">
                <h1>Settings</h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="('/settings') ">Settings</a>
                <i class="fa fa-circle"></i>
            </li> <li>
                <a href="#">Slider</a>
            </li>
        </ul>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="modal-title">{{ $setting['title'] }}</h3>
            </div>
            <div class="panel-body">
                <h4>{{ $setting['description'] }}</h4>
                <form action="{{ URL::current() }}/update" method="post" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label for="{{ $setting->setting_key }}">Set value below for {{ strtolower($setting->title) }}</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-1">
                            <div class="slider" data-min="{{ $setting['limits'][0] }}" data-max="{{ $setting['limits'][1] }}" data-step="{{ $setting['limits'][2] }}" data-value="{{ $setting->setting_value }}">
                                <div class="ui-slider-handle ui-slider-handle--custom"></div>
                            </div>
                            <input type="hidden" name="{{ $setting->setting_key }}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-8">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                            <a href="{{ URL::previous() }}" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection