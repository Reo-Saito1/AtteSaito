<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function workStart()
    {
        $user_id = Auth::id();
        $dt = new Carbon();
        $now_date = $dt->toDateString();
        $now_time = $dt->toTimeString();
        
        \DB::table('attendances')->insert([
            'user_id' => $user_id,
            'work_date' => $now_date,
            'work_start_time' => $now_time,
            'created_at' => $dt,
            'updated_at' => $dt
        ]);

        return view('index');
    }

    public function workEnd()
    {
        $user_id = Auth::id();
        $dt = new Carbon();
        $now_date = $dt->toDateString();
        $now_time = $dt->toTimeString();
        
        \DB::table('attendances')
        ->where('user_id', $user_id)
        ->where('work_date', $now_date)
        ->whereNull('work_end_time')
        ->update([
            'work_end_time' => $now_time,
            'updated_at' => $dt
        ]);

        return view('index');
    }

    public function attendanceList()
    {
        $dt = new Carbon();
        $date = $dt->toDateString();

        $lists = \DB::table('users')
        ->join('attendances', 'users.id', '=', 'attendances.user_id')
        ->join('rests', 'attendances.id', '=', 'rests.attendance_id')
        ->select(
            'users.name',
            'attendances.work_start_time',
            'attendances.work_end_time',
            \DB::raw('SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND, rests.rest_start_time, rests.rest_end_time))) as total_rest_time'),
            \DB::raw('SEC_TO_TIME(
                TIMESTAMPDIFF(SECOND, attendances.work_start_time, attendances.work_end_time) - 
                SUM(TIMESTAMPDIFF(SECOND, rests.rest_start_time, rests.rest_end_time))
                ) as work_time')
        )
        ->where('attendances.work_date',$date)
        ->groupBy('attendances.id')
        ->get();

        return view('list',compact(['date','lists']));
    }
}
