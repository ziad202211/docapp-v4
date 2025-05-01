<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        try {
            $doctor = Auth::user()->doctor;
            if (!$doctor) {
                return response()->json([
                    'success' => false,
                    'message' => 'Doctor profile not found'
                ], 404);
            }

            $notification = Notification::where('doctor_id', $doctor->id)
                ->where('id', $id)
                ->first();

            if (!$notification) {
                return response()->json([
                    'success' => false,
                    'message' => 'Notification not found'
                ], 404);
            }

            $notification->markAsRead();

            return response()->json([
                'success' => true,
                'message' => 'Notification marked as read'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error marking notification as read:', [
                'error' => $e->getMessage(),
                'notification_id' => $id,
                'doctor_id' => Auth::user()->doctor->id ?? 'not found'
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while marking the notification as read'
            ], 500);
        }
    }
} 