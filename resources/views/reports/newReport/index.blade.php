@extends('layouts.app')
@section('content')
 <div class="row">
 	<div class="col-md-8 col-md-offset-2">
 		            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Enter the format of your report</h4>
                </div>
                    <div class="panel-body">
                        <form action="{{ url('newreports') }}" method = "post" role="form">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <select class="form-control" name="employee_id" name="employe_id" required>
                                    <option value="all" selected>All Employees</option>
                                
                                </select>
                            </div>
                            <div class="form-group">
                            	<label for="months"> Months</label>
                            	<select class="form-control" name="month" id="month" required>
                                   <option value="January">January</option>
                                   <option value="February">February</option>
                                   <option value="March">March</option>
                                   <option value="April">April</option>
                                   <option value="May">May</option>
                                   <option value="June">June</option>
                                   <option value="July">July</option>
                                   <option value="August">August</option>
                                   <option value="September">September</option>
                                   <option value="October">October</option>
                                   <option value="November">November</option>
                                   <option value="December">December</option>
                               </select>
                            </div>

                            <div class="form-group">
                            	<label for="months"> Calendar Year</label>
                            	<select class="form-control" name="calendar_year">
                            			<option value="2017"> 2017</option>
                            			<option value="2018"> 2018</option>
                            	</select>
                            </div>

	                        <div class="form-group">
	                            <select name="format" id="format" class="form-control">
	                                <option value="xls" selected>Excel XLS</option>
	                                <option value="xlsx">Excel 2007 and above XLSX</option>
	                                {{--<option value="pdf">PDF</option>--}}
	                            </select>
	                        </div>
	                        <div class="form-group">
                                <input type="submit" class="btn btn-success" value="Generate">
                                <a href="{{ isset($employee->id) ? asset('/employees/'.$employee->id) : asset('attendance') }}"></a>
                                <a href="#" class="btn btn-warning">Cancel</a>
                    </div>
             </form>
            </div>
        </div>
 	</div>
 </div>

@endsection