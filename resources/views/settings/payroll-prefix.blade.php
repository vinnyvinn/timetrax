@extends('layouts.app')
@section('content')
    <div class="col-sm-offset-2 col-sm-8">
        {{--@if(count($errors) > 0)--}}
            {{--<div class="col-sm-12 alert alert-danger">--}}
                {{--@foreach($errors->all() as $error)--}}
                    {{--<p>{{ $error }}</p>--}}
                {{--@endforeach--}}
            {{--</div>--}}
        {{--@endif--}}
            <div class="page-head">
                <div class="page-title">
                    <h1>Settings</h1>
                </div>
            </div>
            <ul class="breadcrumb page-breadcrumb">
                <li><a href="{{ url('/')  }}">Home</a></li>
                <i class="fa fa-circle"></i>
                <li><a href="#">Settings</a></li>
                <i class="fa fa-circle"></i>
                <li><a href="#">Select</a></li>
            </ul>
        @if(Session::has('success'))
            <div class="col-sm-12 alert alert-success">
                <p>Successfully changed</p>
            </div>
        @endif
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="modal-title">{{ $setting->title }}</h4>
                </div>
                <div class="panel-body">
                    {{--<h4>{{ $setting->description }}</h4>--}}
                    <form action="{{ url('settings/prefix-update') }}" method="post" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label for="{{ $setting->setting_key }}">Set  {{ strtolower($setting->title) }} value below</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" name="{{ $setting->setting_key }}"  class="form-control" value="{{ $setting->setting_value }}">
                                </select>
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