<?php

// app/Models/Doctor.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialization',
        'location',
        'title',
        'degree',
        'phone',
        'photo'
    ];

    // Define the relationship to the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }

    // Relationship with Appointments
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // Relationship with Notifications
    public function notifications()
    {
        return $this->hasMany(Notification::class)->orderBy('created_at', 'desc');
    }
}


