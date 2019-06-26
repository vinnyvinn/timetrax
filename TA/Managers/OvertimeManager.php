<?php

namespace TA\Managers;

use App\Attendance;
use App\Shift;
use Carbon\Carbon;

/**
 * Class OvertimeManager
 * @package TA\Managers
 */
class OvertimeManager
{

    /**
     * Get the total overtime minutes given the attendance and shift.
     *
     * @param Shift $shift
     * @param Attendance $attendance
     * @return int
     */
    public static function calculate(Shift $shift, Attendance $attendance)
    {
        $overtime = OvertimeManager::getClockedMinutes($attendance);

        if (OvertimeManager::isShiftDay($shift, $attendance->day)) {
            $overtime = OvertimeManager::getTotalOvertimeMinutes($shift, $attendance);
        }

        return $overtime;
    }

    /**
     * Get the total clocked minuted from the attendance.
     *
     * @param Attendance $attendance
     * @return int
     */
    public static function getClockedMinutes(Attendance $attendance)
    {
        return Carbon::parse($attendance->day . ' ' . $attendance->time_in)
            ->diffInMinutes(Carbon::parse($attendance->day . ' ' . $attendance->time_out));
    }

    /**
     * Calculate the total minutes from the end of the shift.
     *
     * @param Shift $shift
     * @param Attendance $attendance
     * @return int
     */
    private static function getOvertime(Shift $shift, Attendance $attendance)
    {
        // validate that overtime is enabled. return 0 if not
        $overtime = 0;
        $shiftEnd = Carbon::parse($attendance->day . ' ' . $shift->shift_end);
        $timeOut = Carbon::parse($attendance->day . ' ' . $attendance->time_out);

        if ($timeOut->gt($shiftEnd)) {
            $overtime = $timeOut->diffInMinutes($shiftEnd);
        }

        return $overtime;
    }

    /**
     * Calculate the total minutes before the start of the shift.
     *
     * @param Shift $shift
     * @param Attendance $attendance
     * @return int
     */
    private static function getUndertime(Shift $shift, Attendance $attendance)
    {
        // validate that undertime is enabled. return 0 if not
        $undertime = 0;
        $shiftStart = Carbon::parse($attendance->day . ' ' . $shift->shift_start);
        $timeIn = Carbon::parse($attendance->day . ' ' . $attendance->time_in);

        if ($timeIn->lt($shiftStart)) {
            $undertime = $timeIn->diffInMinutes($shiftStart);
        }

        return $undertime;
    }

    /**
     * Get the days the shift is assigned.
     *
     * @param Shift $shift
     * @return mixed
     */
    private static function getShiftDays(Shift $shift)
    {
        return json_decode($shift->day);
    }

    /**
     * Check if the day is a shift day.
     *
     * @param Shift $shift
     * @param $day
     * @return bool
     */
    public static function isShiftDay(Shift $shift, $day)
    {
        $day = Carbon::parse($day)->format('l');

        return in_array($day, OvertimeManager::getShiftDays($shift));
    }

    /**
     * Get the total of overtime and undertime in minutes.
     *
     * @param Shift $shift
     * @param Attendance $attendance
     * @return int
     */
    private static function getTotalOvertimeMinutes(Shift $shift, Attendance $attendance)
    {
        return OvertimeManager::getOvertime($shift, $attendance) + OvertimeManager::getUndertime($shift, $attendance);
    }

}