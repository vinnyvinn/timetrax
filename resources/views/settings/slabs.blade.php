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
                <a href="#">Slabs</a>
            </li>
        </ul>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="modal-title">{{ $title }}</h3>
            </div>
            <div class="panel-body">
                <h4>Add/Remove/Edit overtime slabs for slab type calculation</h4>
                <form action="{{ URL::current() }}/update" method="post" class="form-horizontal">
                    {{ csrf_field() }}
                    <input type="hidden" value="@{{ slab_row }}" name="count" />
                    <div class="form-group">
                        <div class="col-sm-6">
                            <label>Define the slabs below</label>
                        </div>
                        <div class="col-sm-3">
                            <button type="button" id="add-row" class="btn btn-default pull-right">Add a row</button>
                        </div>
                        <div class="col-sm-3">
                            <button type="button" id="remove-row" class="btn btn-default pull-right">Remove last row</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <table class="table table-stripped">
                                <thead>
                                <tr>
                                    <th style="text-align: center">From (hrs)</th>
                                    <th style="text-align: center">To (hrs)</th>
                                    <th style="text-align: center">Rate</th>
                                </tr>
                                </thead>
                                <tbody id="slab_table">
                                @if($slabs->count() < 1)
                                    <tr>
                                        <td>
                                            <div class="col-sm-offset-2 col-sm-8">
                                                <input type="number" min="1" step="0.1" class="form-control" name="beginning_[]" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col-sm-offset-2 col-sm-8">
                                                <input type="number" min="1" step="0.1" class="form-control" name="ending_[]" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col-sm-offset-2 col-sm-8">
                                                <input type="number" min="1" step="0.1" class="form-control" name="rate_[]" />
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    @foreach($slabs as $slab)
                                        <tr>
                                            <td>
                                                <div class="col-sm-offset-2 col-sm-8">
                                                    <input type="number" min="1" step="0.1" class="form-control" name="beginning_[]" value="{{ $slab->beginning }}" />
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-sm-offset-2 col-sm-8">
                                                    <input type="number" min="1" step="0.1" class="form-control" name="ending_[]" value="{{ $slab->ending }}" />
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-sm-offset-2 col-sm-8">
                                                    <input type="number" min="1" step="0.1" class="form-control" name="rate_[]" value="{{ $slab->rate }}" />
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
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
@section('footer')
    <script>
        $('#add-row').click(function (event) {
            if($('#slab_table tr').length == 10) {
               toastr["error"]("You cannot add more row.")
                return false;
            }
            data_row = '<tr  v-for="row in slab_row">'+
                    '<td><div class="col-sm-offset-2 col-sm-8">'+
                    '<input type="number" max="5" min="1" step="0.1" class="form-control" name="beginning_[]" />'+
                    '</div></td><td><div class="col-sm-offset-2 col-sm-8">'+
                    '<input type="number" max="5" min="1" step="0.1" class="form-control" name="ending_[]" />'+
                    '</div></td><td><div class="col-sm-offset-2 col-sm-8">'+
                    '<input type="number" max="5" min="1" step="0.1" class="form-control" name="rate_[]" />'+
                    '</div></td></tr>';
            $('#slab_table').append(data_row);
            console.log('ll');
            event.preventDefault();
        });
        $('#remove-row').click(function(event) {
            if($('#slab_table tr').length == 1) {
                toastr["error"]("You cannot remove any more rows")
                return false;
            }

            $('#slab_table tr:last-child').remove();
            event.preventDefault()
        });
    </script>
    @endsection