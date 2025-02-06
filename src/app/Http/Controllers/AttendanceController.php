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
}
