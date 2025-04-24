<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

require __DIR__.'/auth.php';

// Doctor routes
Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Doctor\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/appointments', [\App\Http\Controllers\Doctor\AppointmentController::class, 'index'])->name('appointments');
    Route::post('/profile/update', [\App\Http\Controllers\Doctor\DoctorController::class, 'updateProfile'])->name('profile.update');
    Route::post('/schedule/store', [\App\Http\Controllers\Doctor\ScheduleController::class, 'store'])->name('schedule.store');
});

// Patient routes
Route::middleware(['auth', 'role:patient'])->group(function () {
    Route::get('/patient/dashboard', [\App\Http\Controllers\Patient\PatientDashboardController::class, 'index'])->name('patient.dashboard');
    Route::get('/patient/doctors/{doctor}/book', [\App\Http\Controllers\Patient\AppointmentController::class, 'showBookingForm'])->name('patient.appointments.create');
    Route::post('/patient/appointments', [\App\Http\Controllers\Patient\AppointmentController::class, 'store'])->name('patient.appointments.store');
});

// Authentication routes
Route::get('register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'create'])->name('register');
Route::post('register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'store']);
Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');


// Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
// Route::post('/register', [RegisteredUserController::class, 'store']);


// Doctor routes
// Route::middleware(['auth', 'role:doctor'])->group(function () {
//     Route::get('/doctor/dashboard', function () {
//         return view('doctor.dashboard');
//     })->name('doctor.dashboard');
//     Route::get('/doctor/appointments', [AppointmentController::class, 'index'])->name('doctor.appointments');
// });
Route::middleware(['auth', 'role:doctor'])->group(function () {
    Route::get('/doctor/dashboard', function () {
        return view('doctor.dashboard');
    })->name('doctor.dashboard');
});
// Patient routes
Route::middleware(['auth', 'role:patient'])->group(function () {
    Route::get('/patient/dashboard', function () {
        return view('patient.dashboard');
    })->name('patient.dashboard');
});
Route::post('/doctor/profile/update', [\App\Http\Controllers\Doctor\DoctorController::class, 'updateProfile'])->name('doctor.profile.update');
Route::post('/doctor/schedule/store', [\App\Http\Controllers\Doctor\ScheduleController::class, 'store'])->name('doctor.schedule.store');
// Patient routes
Route::middleware(['auth', 'role:patient'])->group(function () {
    Route::get('/patient/dashboard', [\App\Http\Controllers\Patient\PatientDashboardController::class, 'index'])->name('patient.dashboard');
});
///////
// use App\Http\Controllers\Doctor\AppointmentController;

// Doctor dashboard



Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

///////
// Route::middleware(['auth'])->group(function () {
//     Route::get('/doctor/dashboard', function () {
//         return view('doctor.dashboard');
//     });

//     Route::get('/patient/dashboard', function () {
//         return view('patient.dashboard');
//     });
// });


