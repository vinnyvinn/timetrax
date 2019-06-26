<html>
<tr>
    <td style="border: 1px solid #000000"><b>Payroll Number</b></td>
    <td style="border: 1px solid #000000"><b>First Name</b></td>
    <td style="border: 1px solid #000000"><b>Last Name</b></td>
    <td style="border: 1px solid #000000"><b>overtime Hours</b></td>
    <td style="border: 1px solid #000000"><b>Clocked Hours</b></td>
</tr>
@foreach($overtimes as $overtime)
    <tr>
        <td style="border: 1px solid #000000">{{ getPayrollNumberPrefix() . $overtime->employee->payroll_number }}</td>
        <td style="border: 1px solid #000000">{{ $overtime->employee->first_name }}</td>
        <td style="border: 1px solid #000000">{{ $overtime->employee->last_name }}</td>
        <td style="border: 1px solid #000000">{{ number_format((($overtime->overtime_minutes)/60),2) }}</td>
        <td style="border: 1px solid #000000">{{ number_format((($overtime->clocked_minutes)/60),2) }}</td>
    </tr>
@endforeach
</html>