<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Doctor;  // Add Doctor model
use App\Models\Patient; // Add Patient model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class RegisteredUserController extends Controller
{
    // Show registration form
    public function create()
    {
        return view('auth.register');
    }

    // Handle the registration form submission
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'role' => 'required|in:doctor,patient',
            'gender' => 'required|in:male,female',
            'specialization' => 'nullable|string|max:255',
            'medical_record' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
        ]);
    
        // Log the role value to help debug
        \Log::info('Validated data:', $validated);
    
        // Create the user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'gender' => $validated['gender'],
        ]);
    
        // Check the role and create associated doctor or patient record
        if ($validated['role'] === 'doctor') {
            $doctor = new Doctor([
                'user_id' => $user->id,
                'specialization' => $validated['specialization'] ?? 'General Medicine',
                'location' => 'Clinic',
                'title' => 'Dr. ' . $user->name,
                'degree' => 'MD',
                'phone' => '000-000-0000'
            ]);
            $user->doctor()->save($doctor);
            \Log::info('Doctor profile created:', ['doctor' => $doctor->toArray()]);
        } elseif ($validated['role'] === 'patient') {
            Patient::create([
                'user_id' => $user->id,
                'medical_record' => $validated['medical_record'] ?? 'No records available',
                'date_of_birth' => $validated['date_of_birth'] ?? '1990-01-01',
            ]);
        }
    
        // Redirect to login page with success message
        return redirect()->route('login')->with('success', 'Registration successful!');

    }
}