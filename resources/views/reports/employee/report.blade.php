<html>
<tr>
    <td style="border: 1px solid #000000"><b>Payroll number</b></td>
    <td style="border: 1px solid #000000"><b>First Name</b></td>
    <td style="border: 1px solid #000000"><b>Last Name</b></td>
    <td style="border: 1px solid #000000"><b>Email</b></td>
</tr>
@foreach($employees as $employee)
    <tr>
        <td style="border: 1px solid #000000">{{ getPayrollNumberPrefix() . $employee->payroll_number }}</td>
        <td style="border: 1px solid #000000">{{ $employee->first_name }}</td>
        <td style="border: 1px solid #000000">{{ $employee->last_name }}</td>
        <td style="border: 1px solid #000000">
            @if($employee->user)
            {{ $employee->user->email }}
            @endif
        </td>
    </tr>
@endforeach
</html>