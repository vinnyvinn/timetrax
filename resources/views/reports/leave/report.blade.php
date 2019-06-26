<html>
<tr>
    <td style="border: 1px solid #000000"><b>Start date</b></td>
    <td style="border: 1px solid #000000"><b>End date</b></td>
    <td style="border: 1px solid #000000"><b>Payroll Number</b></td>
    <td style="border: 1px solid #000000"><b>Status</b></td>
    <td style="border: 1px solid #000000"><b>First Name</b></td>
    <td style="border: 1px solid #000000"><b>Last Name</b></td>
</tr>
@foreach($leaves as $leave)
    <tr>
        <td style="border: 1px solid #000000">{{ Carbon\Carbon::parse($leave->start_date)->format('d,F,Y') }}</td>
        <td style="border: 1px solid #000000">{{ Carbon\Carbon::parse($leave->end_date)->format('d,F,Y') }}</td>
        <td style="border: 1px solid #000000">{{ getPayrollNumberPrefix() . $leave->employee->payroll_number }}</td>
        <td style="border: 1px solid #000000">{{ $leave->status }}</td>
        <td style="border: 1px solid #000000">{{ $leave->employee->first_name }}</td>
        <td style="border: 1px solid #000000">{{ $leave->employee->last_name }}</td>
    </tr>
@endforeach
</html>