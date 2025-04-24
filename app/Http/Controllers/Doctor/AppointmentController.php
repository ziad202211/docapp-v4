<?php
namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        // Your logic for displaying appointments goes here
        return view('doctor.appointments'); // Adjust as needed
    }
}

