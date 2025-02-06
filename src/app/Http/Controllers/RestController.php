<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class RestController extends Controller
{
    public function restStart()
    {
        $user_id = Auth::id();
        $dt = new Carbon();
        $now_date = $dt->toDateString();
        $now_time = $dt->toTimeString();
        
        //attendancesの検索
        $attendance_id = \DB::table('attendances')->where('work_date', $now_date)->whereNull('work_end_time')->value('id'); 

        \DB::table('rests')->insert([
            'attendance_id' => $attendance_id,
            'rest_start_time' => $now_time,
            'created_at' => $dt,
            'updated_at' => $dt
        ]);

        return view('index');
    }

    public function restEnd()
    {
        $user_id = Auth::id();
        $dt = new Carbon();
        $now_date = $dt->toDateString();
        $now_time = $dt->toTimeString();

        //attendancesの検索
        $attendance_id = \DB::table('attendances')->where('work_date', $now_date)->whereNull('work_end_time')->value('id'); 
        
        \DB::table('rests')
        ->where('attendance_id', $attendance_id)
        ->whereNull('rest_end_time')
        ->update([
            'rest_end_time' => $now_time,
            'updated_at' => $dt
        ]);

        return view('index');
    }    
}
