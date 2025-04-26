<?php
// app/Http/Controllers/PatientAppointmentController.php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientAppointmentController extends Controller
{
    // Show the booking page
    public function create($doctor_id)
    {
        $doctor = Doctor::with('schedules')->findOrFail($doctor_id);

        return view('patient.book-appointment', compact('doctor'));
    }

    // Save the appointment
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
        ]);

        Appointment::create([
            'doctor_id' => $request->doctor_id,
            'patient_id' => Auth::id(), // Assuming patient is logged in
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => 'pending',
        ]);

        return redirect()->route('patient.dashboard')->with('success', 'Appointment booked successfully!');
    }
}

