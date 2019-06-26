<html>
<tr>
    <td style="border: 1px solid #000000"><b>Start Date</b></td>
    <td style="border: 1px solid #000000"><b>{{ $start_date }}</b></td>
    <td style="border: 1px solid #000000"><b>End Date</b></td>
    <td style="border: 1px solid #000000"><b>{{ $end_date }}</b></td>
    <td style="border: 1px solid #000000"><b>Days</b></td>
    <td style="border: 1px solid #000000"><b>{{ \Carbon\Carbon::parse($end_date)->diffInDays(\Carbon\Carbon::parse($start_date)) }}</b></td>
</tr>
<tr>
    <td colspan="6"></td>
</tr>
<tr >
    <td style="border: 1px solid #000000"><b>Payroll number</b></td>
    <td style="border: 1px solid #000000"><b>First Name</b></td>
    <td style="border: 1px solid #000000"><b>Last Name</b></td>
    <td style="border: 1px solid #000000"><b>Shift</b></td>
    <td style="border: 1px solid #000000"><b>Hours Worked</b></td>
</tr>
{{--@foreach($attendances->groupBy('payroll_number') as $attendanceGroup)--}}
    {{--{{ dd($attendanceGroup) }}--}}
    @foreach($attendances as $attendance)
        <tr>
            <td style="border: 1px solid #000000">{{ getPayrollNumberPrefix() . $attendance->payroll_number }}</td>
            <td style="border: 1px solid #000000">{{ $attendance->first_name }}</td>
            <td style="border: 1px solid #000000">{{ $attendance->last_name }}</td>
            <td style="border: 1px solid #000000">{{ implode(', ' , $attendance->shifts) }}</td>
            <td style="border: 1px solid #000000">{{ round($attendance->totalHours, 2) }}</td>
        </tr>
    @endforeach
{{--@endforeach--}}
</html>