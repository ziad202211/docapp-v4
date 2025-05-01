<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                Log::error('No authenticated user found in DashboardController');
                return redirect()->route('login');
            }

            Log::info('Dashboard accessed by user:', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'user_name' => $user->name,
                'user_role' => $user->role
            ]);

            // Get the doctor profile
            $doctor = Doctor::where('user_id', $user->id)->first();
            
            if (!$doctor) {
                Log::error('Doctor profile not found for user:', [
                    'user_id' => $user->id,
                    'user_email' => $user->email
                ]);

                // Try to create the doctor profile
                try {
                    $doctor = Doctor::create([
                        'user_id' => $user->id,
                        'specialization' => 'General Medicine',
                        'location' => 'Clinic',
                        'title' => 'Dr. ' . $user->name,
                        'degree' => 'MD',
                        'phone' => '000-000-0000'
                    ]);
                    Log::info('Doctor profile created in controller:', [
                        'doctor_id' => $doctor->id,
                        'user_id' => $doctor->user_id,
                        'doctor_data' => $doctor->toArray()
                    ]);
                } catch (\Exception $e) {
                    Log::error('Error creating doctor profile in controller:', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                        'user_id' => $user->id
                    ]);
                    return redirect()->back()->with('error', 'Doctor profile not found. Please contact support.');
                }
            }

            // Load notifications with proper formatting
            $notifications = Notification::where('doctor_id', $doctor->id)
                ->whereNull('read_at')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function($notification) {
                    $data = is_array($notification->data) ? $notification->data : json_decode($notification->data, true);
                    return [
                        'id' => $notification->id,
                        'doctor_id' => $notification->doctor_id,
                        'type' => $notification->type,
                        'data' => $data,
                        'read_at' => $notification->read_at,
                        'created_at' => $notification->created_at
                    ];
                });

            Log::info('Loaded data:', [
                'doctor_id' => $doctor->id,
                'notifications_count' => $notifications->count(),
                'notifications' => $notifications->toArray()
            ]);

            return view('doctor.dashboard', [
                'notifications' => $notifications,
                'doctor' => $doctor
            ]);
        } catch (\Exception $e) {
            Log::error('Error in DashboardController@index: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'An error occurred while loading the dashboard.');
        }
    }
}

