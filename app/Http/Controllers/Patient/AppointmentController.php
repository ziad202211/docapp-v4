<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    /**
     * Display the booking form for a specific doctor
     */
    public function showBookingForm($doctorId)
    {
        $doctor = Doctor::with('user', 'schedules')->findOrFail($doctorId);
        
        // Get existing appointments for the next 7 days
        $startDate = now();
        $endDate = now()->addDays(7);
        
        $existingAppointments = Appointment::where('doctor_id', $doctorId)
            ->whereBetween('appointment_date', [$startDate, $endDate])
            ->get()
            ->map(function($appointment) {
                return [
                    'date' => $appointment->appointment_date->format('Y-m-d'),
                    'time' => $appointment->appointment_time
                ];
            })
            ->toArray();
            
        // Debug the data
        \Log::info('Existing appointments:', $existingAppointments);
            
        return view('patient.book-appointment', compact('doctor', 'existingAppointments'));
    }

    /**
     * Store a new appointment
     */
    public function store(Request $request)
    {
        try {
            \Log::info('Appointment booking request received:', $request->all());

            // Ensure we're returning JSON
            if (!$request->wantsJson() && !$request->ajax()) {
                \Log::warning('Invalid request format received:', [
                    'headers' => $request->headers->all(),
                    'content_type' => $request->getContentType(),
                    'accept' => $request->header('Accept')
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid request format. Please try again.'
                ], 400);
            }

            // Validate the request data
            $validatedData = $request->validate([
                'doctor_id' => 'required|exists:doctors,id',
                'appointment_date' => 'required|date',
                'appointment_time' => 'required|string'
            ]);

            \Log::info('Validated data:', $validatedData);

            // Get the authenticated user's patient ID
            $user = auth()->user();
            \Log::info('Authenticated user:', ['user' => $user]);

            $patient = $user->patient;
            if (!$patient) {
                \Log::warning('Patient profile not found for user:', ['user_id' => $user->id]);
                return response()->json([
                    'success' => false,
                    'message' => 'Please complete your patient profile before booking an appointment.'
                ], 422);
            }

            \Log::info('Patient found:', ['patient' => $patient]);

            // Check if the doctor is available on the selected day
            $day = date('l', strtotime($validatedData['appointment_date']));
            $schedule = DoctorSchedule::where('doctor_id', $validatedData['doctor_id'])
                ->where('day', $day)
                ->first();

            if (!$schedule) {
                \Log::warning('Doctor schedule not found:', [
                    'doctor_id' => $validatedData['doctor_id'],
                    'day' => $day,
                    'date' => $validatedData['appointment_date']
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'The doctor is not available on the selected day.'
                ], 422);
            }

            \Log::info('Doctor schedule found:', ['schedule' => $schedule]);

            // Check if the selected time is within working hours
            $selectedTime = strtotime($validatedData['appointment_time']);
            $startTime = strtotime($schedule->start_time . ':00');
            $endTime = strtotime($schedule->end_time . ':00');

            if ($selectedTime < $startTime || $selectedTime > $endTime) {
                \Log::warning('Selected time outside working hours:', [
                    'selected_time' => $validatedData['appointment_time'],
                    'start_time' => $schedule->start_time,
                    'end_time' => $schedule->end_time
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'The selected time is not within the doctor\'s working hours.'
                ], 422);
            }

            // Check if the appointment slot is already taken
            $existingAppointment = Appointment::where('doctor_id', $validatedData['doctor_id'])
                ->where('appointment_date', $validatedData['appointment_date'])
                ->where('appointment_time', $validatedData['appointment_time'])
                ->exists();

            if ($existingAppointment) {
                \Log::warning('Appointment slot already taken:', [
                    'doctor_id' => $validatedData['doctor_id'],
                    'date' => $validatedData['appointment_date'],
                    'time' => $validatedData['appointment_time']
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'This time slot is already booked. Please choose another time.'
                ], 422);
            }

            // Create the appointment
            try {
                $appointmentData = [
                    'doctor_id' => $validatedData['doctor_id'],
                    'patient_id' => $patient->patient_id, // Use patient_id instead of id
                    'appointment_date' => $validatedData['appointment_date'],
                    'appointment_time' => $validatedData['appointment_time'],
                    'status' => 'pending'
                ];

                \Log::info('Attempting to create appointment with data:', $appointmentData);

                $appointment = Appointment::create($appointmentData);

                \Log::info('Appointment created successfully:', ['appointment' => $appointment]);

                // Format the date and time for display
                $formattedDate = date('F j, Y', strtotime($validatedData['appointment_date']));
                $formattedTime = date('g:i A', strtotime($validatedData['appointment_time']));

                return response()->json([
                    'success' => true,
                    'message' => 'Appointment booked successfully! Your appointment is scheduled for ' . $formattedDate . ' at ' . $formattedTime
                ], 200);
            } catch (\Exception $e) {
                \Log::error('Error creating appointment in database:', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'data' => $appointmentData ?? null
                ]);
                throw $e;
            }

        } catch (\Exception $e) {
            \Log::error('Error in appointment booking:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while booking the appointment. Please try again.',
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Display the patient's appointments
     */
    public function index()
    {
        $user = Auth::user();
        $appointments = Appointment::with('doctor.user')
            ->where('patient_id', $user->patient->id)
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();

        return view('patient.appointments', compact('appointments'));
    }

    /**
     * Cancel an appointment
     */
    public function cancel($id)
    {
        try {
            $appointment = Appointment::findOrFail($id);
            
            // Check if the appointment belongs to the authenticated patient
            if ($appointment->patient_id !== Auth::user()->patient->id) {
                return back()->with('error', 'You are not authorized to cancel this appointment.');
            }

            // Check if the appointment can be cancelled (e.g., not too close to the appointment time)
            $appointmentDateTime = strtotime($appointment->appointment_date . ' ' . $appointment->appointment_time);
            $currentDateTime = time();
            $hoursDifference = ($appointmentDateTime - $currentDateTime) / 3600;

            if ($hoursDifference < 24) {
                return back()->with('error', 'Appointments can only be cancelled at least 24 hours before the scheduled time.');
            }

            $appointment->status = 'cancelled';
            $appointment->save();

            return back()->with('success', 'Appointment cancelled successfully.');
        } catch (\Exception $e) {
            Log::error('Error cancelling appointment: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while cancelling the appointment.');
        }
    }

    /**
     * Reschedule an appointment
     */
    public function reschedule(Request $request, $id)
    {
        try {
            $appointment = Appointment::findOrFail($id);
            
            // Check if the appointment belongs to the authenticated patient
            if ($appointment->patient_id !== Auth::user()->patient->id) {
                return back()->with('error', 'You are not authorized to reschedule this appointment.');
            }

            $request->validate([
                'appointment_date' => 'required|date',
                'appointment_time' => 'required|date_format:g:i A'
            ]);

            // Check if the new time slot is available
            $existingAppointment = Appointment::where('doctor_id', $appointment->doctor_id)
                ->where('appointment_date', $request->appointment_date)
                ->where('appointment_time', $request->appointment_time)
                ->where('id', '!=', $id)
                ->exists();

            if ($existingAppointment) {
                return back()->with('error', 'This time slot is already booked. Please choose another time.');
            }

            $appointment->appointment_date = $request->appointment_date;
            $appointment->appointment_time = $request->appointment_time;
            $appointment->status = 'rescheduled';
            $appointment->save();

            return back()->with('success', 'Appointment rescheduled successfully.');
        } catch (\Exception $e) {
            Log::error('Error rescheduling appointment: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while rescheduling the appointment.');
        }
    }
} 