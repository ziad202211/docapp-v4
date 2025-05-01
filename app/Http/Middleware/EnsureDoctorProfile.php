<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EnsureDoctorProfile
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        
        if (!$user) {
            Log::error('No authenticated user found');
            return redirect()->route('login');
        }
        
        if ($user->role === 'doctor') {
            Log::info('Checking doctor profile for user:', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'user_name' => $user->name,
                'user_role' => $user->role
            ]);

            try {
                $doctor = Doctor::where('user_id', $user->id)->first();
                
                if (!$doctor) {
                    Log::info('Creating doctor profile for user:', [
                        'user_id' => $user->id,
                        'user_email' => $user->email,
                        'user_name' => $user->name
                    ]);

                    $doctor = Doctor::create([
                        'user_id' => $user->id,
                        'specialization' => 'General Medicine',
                        'location' => 'Clinic',
                        'title' => 'Dr. ' . $user->name,
                        'degree' => 'MD',
                        'phone' => '000-000-0000'
                    ]);

                    Log::info('Doctor profile created successfully:', [
                        'doctor_id' => $doctor->id,
                        'user_id' => $doctor->user_id,
                        'doctor_data' => $doctor->toArray()
                    ]);
                } else {
                    Log::info('Doctor profile already exists:', [
                        'doctor_id' => $doctor->id,
                        'user_id' => $doctor->user_id,
                        'doctor_data' => $doctor->toArray()
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Error in EnsureDoctorProfile middleware:', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'user_id' => $user->id
                ]);
                return redirect()->back()->with('error', 'An error occurred while checking your doctor profile. Please try again.');
            }
        }

        return $next($request);
    }
} 