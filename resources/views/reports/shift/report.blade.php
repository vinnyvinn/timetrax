<html>
<tr>
    <td style="border: 1px solid #000000"><b>Name</b></td>
    <td style="border: 1px solid #000000"><b>Shift Start</b></td>
    <td style="border: 1px solid #000000"><b>Shift End</b></td>
    <td style="border: 1px solid #000000"><b>Breaks</b></td>
    <td style="border: 1px solid #000000"><b>Days</b></td>

</tr>
@foreach($shifts as $shift)
    <tr>
        <td style="border: 1px solid #000000">{{ $shift->name }}</td>
        <td style="border: 1px solid #000000">{{ $shift->shift_start}}</td>
        <td style="border: 1px solid #000000">{{ $shift->shift_end }}</td>
        <td style="border: 1px solid #000000">{{ $shift->break }}</td>
        <td style="border: 1px solid #000000">{{ implode(', ', json_decode($shift->day)) }}</td>
    </tr>
@endforeach
</html>