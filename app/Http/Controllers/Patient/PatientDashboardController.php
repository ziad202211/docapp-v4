<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;

class PatientDashboardController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('user')->get();
        return view('patient.dashboard', compact('doctors'));
    }
}