<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PatientProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $patient = $user->patient;
        return view('patient.patient-profile', compact('user', 'patient'));
    }

    public function update(Request $request)
    {
        try {
            Log::info('Profile update request received:', $request->all());

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
                'phone' => 'required|string|max:20',
                'gender' => 'required|in:Male,Female',
                'medical_record' => 'nullable|string',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $user = Auth::user();
            $patient = $user->patient;

            if (!$patient) {
                Log::error('Patient record not found for user:', ['user_id' => $user->id]);
                return response()->json([
                    'success' => false,
                    'message' => 'Patient record not found'
                ], 404);
            }

            // Update user data
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'gender' => $request->gender,
            ]);

            Log::info('User data updated:', ['user_id' => $user->id]);

            // Update patient data
            $patientData = [
                'phone' => $request->phone,
                'medical_record' => $request->medical_record,
            ];

            // Handle photo upload
            if ($request->hasFile('photo')) {
                // Delete old photo if exists
                if ($patient->photo) {
                    Storage::delete('public/patient-photos/' . $patient->photo);
                }
                
                $path = $request->file('photo')->store('patient-photos', 'public');
                $patientData['photo'] = basename($path);
                Log::info('Photo uploaded:', ['path' => $path]);
            }

            $patient->update($patientData);
            Log::info('Patient data updated:', ['patient_id' => $patient->patient_id]);

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating profile:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating your profile. Please try again.'
            ], 500);
        }
    }
} 