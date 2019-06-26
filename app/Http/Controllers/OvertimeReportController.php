<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Employee;
use App\EmployeeOvertime;
use App\Overtime;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;

class OvertimeReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('reports.overtime.create')->with('employees', Employee::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $overtimes = Attendance::with('employee')
            ->when($request->employee_id != 'all', function ($query) use ($request) {
                return $query->where('employee_id', $request->get('employee_id'));
            })
            ->where('overtime_minutes', '>', 0 )
            ->where('clocked_minutes', '>', 0 )
            ->where('created_at', '>=', Carbon::parse($request->get('start_date'))->startOfDay())
            ->where('created_at', '<=', Carbon::parse($request->get('end_date'))->endOfDay())
            ->get();
//        $overtime = $overtimes->map(function ($attendance) {
//            $overtimes->shifts = $attendance->employee->shifts->map(function ($shift) {
//                return $shift->name;
//            })->toArray();
//
//            return $attendance;
//        });

        $excel = Excel::create('overtime', function ($excel) use ($overtimes)
        {

            $excel->sheet('New sheet', function ($sheet) use ($overtimes)
            {

                $sheet->loadView('reports.overtime.report')->withOvertimes($overtimes);

            });

        })->download($request->get('format'));



        dd($excel);

        return view('reports.overtime.report')->withOvertimes($overtimes);
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
