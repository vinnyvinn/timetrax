<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Leave;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;

class LeaveReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('reports.leave.create')->with('employees', Employee::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $data = $request->start_date;
//        $leaves = Leave::all()->reject(function($item) use ($data) {
//          dd($item->start_date, Carbon::parse($data));
//            return $item->whereLoose('start_date', '>=', Carbon::parse($data));
//        });
        $leave = Leave::with(['employee'])
            ->when($request->employee_id != 'all', function($query) use ($request){
                return $query->where('employee_id', $request->get('employee_id'));
            })
            ->where('start_date' ,'>=', Carbon::parse($request->get('start_date'))->startOfDay()->format('Y-m-d'))
            ->where('start_date' ,'<=', Carbon::parse($request->get('end_date'))->endOfDay()->format('Y-m-d'))
            ->where('status', $request->get('status'))
            ->get();


        $excel = Excel::create('leave', function ($excel) use ($leave)
        {

            $excel->sheet('New sheet', function ($sheet) use ($leave)
            {

                $sheet->loadView('reports.leave.report')->withLeaves($leave);

            });

        })->download($request->get('format'));


        dd($excel);

        return view('reports.leave.report')->withLeaves($leave);
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
        //
    }
}
