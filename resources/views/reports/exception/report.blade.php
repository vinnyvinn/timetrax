<html>
<table cellpadding="5" cellspacing="0"{{ $hasWidth ? ' width=185mm' : '' }}>
    <thead>
    <tr>
        <td colspan="7" style="text-align: center; text-transform: uppercase"><strong>Attendance For: {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }} </strong></td>
    </tr>
    </thead>
    <tbody>

    @foreach($attendances->groupBy('employee_id') as $attendanceGroup)
        <tr>
            <td colspan="7" style="text-transform: uppercase">
                <strong>
                    {{ getPayrollNumberPrefix() . $attendanceGroup->first()->payroll_number }}.
                    {{ $attendanceGroup->first()->first_name }} {{ $attendanceGroup->first()->last_name }}
                </strong>
            </td>
        </tr>

        <tr style="background-color:#e5e5e5;">
            <td><strong>Date</strong></td>
            <td><strong>Shift</strong></td>
            <td><strong>Time in</strong></td>
            <td><strong>Time out</strong></td>
            <td style="text-align: right;"><strong>Expected Hrs</strong></td>
            <td style="text-align: right;"><strong>Clocked Hrs</strong></td>
            <td style="text-align: right;"><strong>Diff.</strong></td>
        </tr>


        <?php
            $rowNumber = 0;
            $expectedHours = 0;
            $clockedMinutes = 0;
        ?>

        @foreach($attendanceGroup as $attendance)

        <?php
        $currentMins = (Carbon\Carbon::parse('2017-01-01 ' . $attendance->time_out)->diffInMinutes(Carbon\Carbon::parse('2017-01-01 ' . $attendance->time_in)));
        $rowNumber++;
        $expectedHours += $attendance->shiftHours;
        $clockedMinutes += $currentMins;
        ?>

        <tr{{ $rowNumber % 2 == 0 ? ' style=background-color:#e5e5e5;' : '' }}>
            <td>{{ Carbon\Carbon::parse($attendance->day)->format('M d') }}</td>
            <td>{{ $attendance->shiftName }}</td>
            <td>{{ $attendance->time_in }}</td>
            <td>{{ $attendance->time_out }}</td>
            <td style="text-align: right">{{ number_format($attendance->shiftHours, 2) }}</td>
            <td style="text-align: right">{{ number_format($currentMins/60, 2) }}</td>
            <td style="text-align: right">{{ number_format(($currentMins/60) - $attendance->shiftHours, 2) }}</td>
        </tr>

        @endforeach
        <tr style="background-color:#e5e5e5; text-align: right;">
            <td colspan="4">
                <strong>TOTAL HOURS</strong>
            </td>
            <td>
                <strong>{{ number_format($expectedHours, 2) }}</strong>
            </td>
            <td>
                <strong>{{ number_format($clockedMinutes/60, 2) }}</strong>
            </td>
            <td>
                <strong>{{ number_format(($clockedMinutes/60) - $expectedHours, 2) }}</strong>
            </td>
        </tr>
        <tr style=" text-align: right;">
            <td colspan="4">
                <strong>EXCESS HOURS</strong>
            </td>
            <td>
                <strong>{{
                (number_format(($clockedMinutes/60) - $expectedHours, 2) > 0) ?
                   number_format(($clockedMinutes/60) - $expectedHours, 2):
                   0
                }}</strong>
            </td>
        </tr>
        <tr style="background-color:#e5e5e5; text-align: right;">
            <td colspan="4">
                <strong>LESS HOURS</strong>
            </td>
            <td>
                <strong>{{
                (number_format(($clockedMinutes/60) - $expectedHours, 2) < 0) ?
                   (number_format(($clockedMinutes/60) - $expectedHours, 2) * -1) :
                   0
                 }}</strong>
            </td>
        </tr>
        <tr><td colspan="7">&nbsp;</td></tr>
    @endforeach
    </tbody>
</table>
</html>