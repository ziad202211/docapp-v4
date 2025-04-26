<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;

class EnsurePatientProfile
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        
        if ($user && $user->role === 'patient' && !$user->patient) {
            Patient::create([
                'user_id' => $user->id,
                'medical_record' => 'No records available',
                'date_of_birth' => now(),
            ]);
        }

        return $next($request);
    }
} 