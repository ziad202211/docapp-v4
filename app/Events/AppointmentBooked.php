<?php

namespace App\Events;

use App\Models\Appointment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AppointmentBooked implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $appointment;
    public $notification;

    /**
     * Create a new event instance.
     */
    public function __construct(Appointment $appointment, $notification)
    {
        $this->appointment = $appointment;
        $this->notification = $notification;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('private-doctor.' . $this->appointment->doctor->user_id),
        ];
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'appointment' => [
                'id' => $this->appointment->id,
                'doctor_id' => $this->appointment->doctor_id,
                'patient_id' => $this->appointment->patient_id,
                'appointment_date' => $this->appointment->appointment_date,
                'appointment_time' => $this->appointment->appointment_time,
                'status' => $this->appointment->status
            ],
            'notification' => [
                'id' => $this->notification->id,
                'doctor_id' => $this->notification->doctor_id,
                'type' => $this->notification->type,
                'data' => $this->notification->data,
                'created_at' => $this->notification->created_at
            ]
        ];
    }
} 