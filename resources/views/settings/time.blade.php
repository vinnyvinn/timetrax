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
            </li>
        </ul>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="modal-title">{{ $setting->title }}</h3>
            </div>
            <div class="panel-body">

                <form action="{{ URL::current() }}/update" method="post" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label for="{{ $setting->setting_key }}">Set {{ strtolower($setting->title) }}</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="glyphicon glyphicon-time"></i>
                                </div>
                            <input type="text" name="{{ $setting->setting_key }}" class="form-control time" id="pick-time" value="{{ $setting->setting_value }}" required />
                        </div>
                    </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-10 col-sm-2">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="panel-footer clearfix">
                <div class="col-sm-2">
                    <a href="{{ url('settings') }}" class="btn btn-warning"><i class="fa fa-chevron-left"></i> Go back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        (function () {
            $('.time').timepicker({
                minuteStep: 5,
                showInputs: false,
                disableFocus: true
            });
        }());
    </script>
@endsection
