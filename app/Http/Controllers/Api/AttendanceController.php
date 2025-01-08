<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    // checkin
    public function checkin(Request $request)
    {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        // save attendance
        $attendance = new Attendance;
        $attendance->users_id = $request->user()->id;
        $attendance->date = date('Y-m-d');
        $attendance->time_in = date('H:i:s');
        $attendance->latlon_in = $request->latitude . ',' . $request->longitude;
        $attendance->save();

        return response(['message' => 'Checkin Success', 'attendance' => $attendance], 200);
    }

    // checkout
    public function checkout(Request $request)
    {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        // get today attendance
        $attendance = Attendance::where('users_id', $request->user()->id)
            ->where('date', date('Y-m-d'))
            ->first();

        // check if attendance not found
        if (!$attendance) {
            return response(['message' => 'checkin First'], 400);
        }

        // save checkout
        $attendance->time_out = date('H:i:s');
        $attendance->latlon_out = $request->latitude . ',' . $request->longitude;
        $attendance->save();

        return response(['message' => 'Checkout Success', 'attendance' => $attendance], 200);
    }

    // check is checkedin
    public function ischeckedin(Request $request)
    {
        // get today attendance
        $attendance = Attendance::where('users_id', $request->user()->id)
            ->where('date', date('Y-m-d'))
            ->first();

        return response(['checkedin' => $attendance ? true : false], 200);
    }
}
