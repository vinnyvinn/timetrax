<?php

namespace App\Http\Controllers;

use App\Holiday;
use App\Role;
use Illuminate\Http\Request;

use App\Http\Requests;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perPage = request('paginate');
        if (!hasPermission(Role::PERM_HOLIDAY_DELETE))
        {
            return view('holiday.show')->with('holidays', Holiday::paginate($perPage));
        }
        else
        {
            return view('holiday.index')->with('holidays', Holiday::paginate($perPage));
        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('holiday.create')->with('holidays', Holiday::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $formData = $request->all();

        Holiday::create([
            'name' => $formData['holiday'],
            'day' => $formData['holiday_day'],
            'month' => $formData['holiday_month']
        ]);
        flash('You have successfully created a new holiday');

        return redirect()->route('holiday.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $holiday = Holiday::findOrFail($id);
        dd($holiday);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $holiday = Holiday::findOrFail($id);
        $holiday->delete();
        flash('You have successfully deleted the holiday');
        return redirect()->route('holiday.index');
    }
}
