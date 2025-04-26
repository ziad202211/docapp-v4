<?php

// app/Models/Patient.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'medical_record',
        'date_of_birth'
    ];

    protected $primaryKey = 'patient_id';

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Appointments
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
