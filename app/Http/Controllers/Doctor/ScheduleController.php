<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DoctorSchedule;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'availability' => 'required|array',
            'availability.*.from' => 'required|integer|min:0|max:23',
            'availability.*.to' => 'required|integer|min:1|max:24',
        ]);

        $doctorId = Auth::user()->doctor->id;

        // Delete existing schedules for this doctor
        DoctorSchedule::where('doctor_id', $doctorId)->delete();

        // Create new schedules
        foreach ($request->availability as $day => $schedule) {
            if (!isset($schedule['off']) || $schedule['off'] != 1) {
                DoctorSchedule::create([
                    'doctor_id' => $doctorId,
                    'day' => $day,
                    'start_time' => $schedule['from'],
                    'end_time' => $schedule['to'],
                ]);
            }
        }

        return redirect()->back()->with('success', 'Schedule updated successfully!');
    }
} 