<?php

namespace App\Http\Controllers;

use App\Shift;
use App\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('shift.index')->with('shifts', Shift::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('shift.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['day'] = json_encode($data['day']);
        $data['shift_start'] = Carbon::parse($data['shift_start']);
        $data['shift_end'] = Carbon::parse($data['shift_end']);

        Shift::create($data);
        flash('Successfully created shift');
        return redirect()->route('shift.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shift = Shift::findOrFail($id);
        $shift->day = json_decode($shift->day);

        return view('shift.show')->with('shift', $shift);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shift = Shift::findOrFail($id);
        $shift->day = json_decode($shift->day);

        return view('shift.edit')->with('shift', $shift);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['day'] = json_encode($data['day']);
        $data['shift_start'] = Carbon::parse($data['shift_start']);
        $data['shift_end'] = Carbon::parse($data['shift_end']);

        $shift = Shift::findOrFail($id);
        $shift->update($data);
        flash('Successfully edited shift');

        return redirect()->route('shift.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shift = Shift::findOrFail($id);

        if(count($shift->employee))
        {
            flash('You cannot delete a shift with active employees', 'error');
            return redirect()->back();
        }
        $shift->delete();
        flash('Successfully deleted shift');


        return redirect()->route('shift.index');
    }
}
