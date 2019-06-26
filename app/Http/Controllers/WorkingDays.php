<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CalendarDay;
use App\Month;
class WorkingDays extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $calendars=CalendarDay::with(['month'])->get();
            $options=Month::get();
        return view('calendar.index',['calendars'=>$calendars,'options'=>$options]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
                'days' => 'required',
            ]);
    
        if($this->validateRequest($request)){
            $thisYear=date('Y');
            CalendarDay::create([
                'month_id'=>$request->get('month'),
                'days'=>$request->get('days'),
                'year'=>$thisYear
            ]);
            flash("New Working Days Created",'success');
            return redirect()->back();
        }else{
        flash('That Month is already set for this calendar !edit if you need changes done','error');
            return redirect()->back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
         $calendar=CalendarDay::findorFail($id);
            $options=Month::get();
        return view('calendar.edit',['calendar'=>$calendar,'options'=>$options]);
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
        $calendar = CalendarDay::findorFail($request->id);
        // dd($calendar);
        $calendar->days = $request->days;
        $calendar->save();

        flash('you have successfully edited working days');

        return redirect()->route('calendar.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $calendar = CalendarDay::findorFail($id);
        $calendar->delete();

        flash('you have successfully deleted working days');

        return redirect()->back();
        //
    }


    public function validateRequest($request){
        $thisYear=date('Y');
        $check=CalendarDay::where('month_id',$request->month)->where('year',$thisYear)->get();

        if(count($check) >0){

            return false;
        }else{

            return true;
        }
    }
}
