<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientAppointmentHistoryController extends Controller
{
    public function index()
    {
        // Get the authenticated user's patient ID
        $patient = Patient::where('user_id', Auth::id())->first();
        
        if (!$patient) {
            return redirect()->back()->with('error', 'Patient record not found');
        }

        // Get all appointments for the patient with doctor details
        $appointments = Appointment::with(['doctor.user', 'doctor'])
            ->where('patient_id', $patient->patient_id)
            ->orderBy('appointment_date', 'desc')
            ->get();

        return view('patient.patient-appointments-history', compact('appointments'));
    }
} 