@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{ URL::to('dashboard-filter')}}" method="POST">
                {{ csrf_field() }}
                <div class="col-md-6">
                    <label for="site_show" class="text-center font-blue-sharp">Select Site</label>
                    <select class="form-control" name="site_show" id="the_select">
                        <option value="0" {{ $siteselected == 0 ? 'selected' : '' }}>All</option>
                    @foreach($sites as $site)
                        <option value="{{ $site->id }}" {{ $site->id == $siteselected ? 'selected' : '' }}>{{ $site->name  }}</option>
                    @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="site_show" class="text-center font-blue-sharp">Select Date</label>
                        <div class="input-group input-daterange">
                                <input type="text" class="form-control date-filter" value="{{ isset($params) ? $params['from']->format('d-m-Y') : Carbon\Carbon::now()->subDays(1)->format('d-m-Y') }}" name="from">
                                <div class="input-group-addon">to</div>
                                <input type="text" class="form-control date-filter" value="{{ isset($params) ? $params['to']->format('d-m-Y') : Carbon\Carbon::now()->format('d-m-Y')  }}" name="to">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-default pull-right"><span class="glyphicon glyphicon-search"></span> Filter</button>
                                </span>
                        </div>
                    </div>
            </form>
          </div>
        </div>
        <div class="col-sm-12">
            <div class="row margin-top-10">
                <div class="col-sm-4 ">
                    <div class="dashboard-stat2">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-red-haze">{{ $casualcheckin + $staffcheckin + $intern_checkedin}}</h3>
                                <small>EMPLOYEES</small>
                            </div>
                            <div class="icon">
                                <i class="icon-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 ">
                    <div class="dashboard-stat2">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-blue-sharp">{{ $attendance }}</h3>
                                <small>ATTENDANCES</small>
                            </div>
                            <div class="icon">
                                <i class="icon-note"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 ">
                    <div class="dashboard-stat2">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-purple-soft">{{ $leaves }}</h3>
                                <small>LEAVES</small>
                            </div>
                            <div class="icon">
                                <i class="icon-rocket"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="col-sm-6">
                <div class="dashboard-stat2">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-red-haze">{{ $casualcheckin }}</h3>
                                <small>TEMPORARY STAFF PRESENT</small>
                            </div>
                            <div class="icon">
                                <i class="icon-users"></i>
                            </div>
                        </div>
                </div>
            </div>


            <div class="col-sm-6">
                <div class="dashboard-stat2">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-red-haze">{{  $totals['temp'] - $casualcheckin }}</h3>
                                <small>TEMPORARY STAFF ABSENT</small>

                            </div>
                            <div class="icon">
                                <i class="icon-users"></i>
                            </div>
                        </div>

                </div>
            </div>
            <div class="col-sm-6">
                <div class="dashboard-stat2">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-red-haze">{{ $staffcheckin }}</h3>
                                <small>PERMANENT STAFF PRESENT</small>
                            </div>
                            <div class="icon">
                                <i class="icon-users"></i>
                            </div>
                        </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="dashboard-stat2">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-red-haze">{{ $totals['perm'] - $staffcheckin }}</h3>
                                <small>PERMANENT STAFF ABSENT</small>
                            </div>
                            <div class="icon">
                                <i class="icon-users"></i>
                            </div>
                        </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="dashboard-stat2">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-red-haze">{{ $intern_checkedin }}</h3>
                                <small>INTERNS PRESENT</small>
                            </div>
                            <div class="icon">
                                <i class="icon-users"></i>
                            </div>
                        </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="dashboard-stat2">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-red-haze">{{ $totals['intern'] - $intern_checkedin }}</h3>
                                <small>INTERNS ABSENT</small>
                            </div>
                            <div class="icon">
                                <i class="icon-users"></i>
                            </div>
                        </div>
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')

<script type="text/javascript">
    $('.date-filter').datepicker({
        autoclose: true,
        endDate: '0d',
        format: 'dd-mm-yyyy'
    });
</script>
@endsection
