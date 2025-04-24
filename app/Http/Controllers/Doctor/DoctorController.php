<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    public function updateProfile(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $doctor = Doctor::where('user_id', Auth::id())->first();
        
        if (!$doctor) {
            $doctor = new Doctor();
            $doctor->user_id = Auth::id();
        }

        $doctor->title = $request->title;
        $doctor->degree = $request->degree;
        $doctor->location = $request->location;
        $doctor->phone = $request->phone;

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($doctor->photo) {
                Storage::delete('public/' . $doctor->photo);
            }
            
            $path = $request->file('photo')->store('doctor-photos', 'public');
            $doctor->photo = $path;
        }

        $doctor->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
} 