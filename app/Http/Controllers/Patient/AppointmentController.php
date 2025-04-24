<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function showBookingForm($doctorId)
    {
        $doctor = Doctor::with('user', 'schedules')->findOrFail($doctorId);
        return view('patient.book-appointment', compact('doctor'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i'
        ]);

        // Get the selected day of the week
        $selectedDay = date('l', strtotime($request->appointment_date));
        
        // Check if the doctor is available on that day
        $isAvailable = DoctorSchedule::where('doctor_id', $request->doctor_id)
            ->where('day', $selectedDay)
            ->exists();

        if (!$isAvailable) {
            return back()->with('error', 'The doctor is not available on the selected day.');
        }

        // Check if the time slot is within the doctor's working hours
        $selectedTime = strtotime($request->appointment_time);
        $schedule = DoctorSchedule::where('doctor_id', $request->doctor_id)
            ->where('day', $selectedDay)
            ->first();

        $startTime = strtotime($schedule->start_time . ':00');
        $endTime = strtotime($schedule->end_time . ':00');

        if ($selectedTime < $startTime || $selectedTime >= $endTime) {
            return back()->with('error', 'The selected time is not within the doctor\'s working hours.');
        }

        // Check if the appointment slot is already taken
        $existingAppointment = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->exists();

        if ($existingAppointment) {
            return back()->with('error', 'This time slot is already booked. Please choose another time.');
        }

        $appointment = Appointment::create([
            'patient_id' => Auth::user()->patient->id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time
        ]);

        return redirect()->route('patient.dashboard')->with('success', 'Appointment booked successfully!');
    }
} 