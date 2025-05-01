<?php
namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    public function index()
    {
        try {
            $doctor = Auth::user()->doctor;
            
            if (!$doctor) {
                Log::error('Doctor profile not found for user: ' . Auth::id());
                return redirect()->back()->with('error', 'Doctor profile not found.');
            }

            // Get appointments with all necessary relationships
            $appointments = Appointment::with([
                'patient.user',
                'doctor.user'
            ])
            ->where('doctor_id', $doctor->id)
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();

            // Log appointment details for debugging
            foreach ($appointments as $appointment) {
                Log::info('Appointment details:', [
                    'appointment_id' => $appointment->id,
                    'patient_id' => $appointment->patient_id,
                    'has_patient' => $appointment->patient ? 'yes' : 'no',
                    'has_user' => $appointment->patient && $appointment->patient->user ? 'yes' : 'no'
                ]);
            }

            return view('doctor.appointments', compact('appointments'));
        } catch (\Exception $e) {
            Log::error('Error in AppointmentController@index: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while loading appointments.');
        }
    }

    public function complete(Appointment $appointment)
    {
        try {
            // Verify the appointment belongs to the authenticated doctor
            if ($appointment->doctor_id !== Auth::user()->doctor->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized action.'
                ], 403);
            }

            // Update the appointment status
            $appointment->status = 'completed';
            $appointment->save();

            return response()->json([
                'success' => true,
                'message' => 'Appointment marked as completed successfully.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error completing appointment: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the appointment status.'
            ], 500);
        }
    }
}

