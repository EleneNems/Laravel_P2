<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\PaymentController;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Visit;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider and assigned
| to the "web" middleware group. 
|
*/

// ---------------------------------------------------
// Public Routes
// ---------------------------------------------------
Route::get('/', function () {
    return view('welcome');
});

// ---------------------------------------------------
// Dashboard (requires login & verified email)
// ---------------------------------------------------
Route::get('/dashboard', function () {
    $patientsCount = Patient::count();
    $doctorsCount = Doctor::count();
    $appointmentsCount = Appointment::count();
    $visitsCount = Visit::count(); // ✅ Add this

    return view('dashboard', compact(
        'patientsCount',
        'doctorsCount',
        'appointmentsCount',
        'visitsCount' // ✅ Include in compact
    ));
})->middleware(['auth', 'verified'])->name('dashboard');
// ---------------------------------------------------
// Profile Routes (Breeze style)
// ---------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ---------------------------------------------------
// Admin Routes
// Only admin can manage doctors and patients
// ---------------------------------------------------
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('doctors', DoctorController::class);
    Route::resource('patients', PatientController::class);
});

// ---------------------------------------------------
// Receptionist & Admin Routes
// Manage appointments
// ---------------------------------------------------
Route::middleware(['auth', 'role:admin,receptionist'])->group(function () {
    Route::resource('appointments', AppointmentController::class);
    // Optional: add search/filter routes for appointments
    // Route::get('appointments/search', [AppointmentController::class, 'search'])->name('appointments.search');
});

// ---------------------------------------------------
// Doctor Routes
// Doctors handle visits (create/update)
# Doctors should only manage their own visits
// ---------------------------------------------------
Route::middleware(['auth', 'role:doctor'])->group(function () {
    Route::resource('visits', VisitController::class)->except(['index']);
});

// ---------------------------------------------------
// Patient Routes
// Patients see their own appointments & payments
// ---------------------------------------------------
Route::middleware(['auth', 'role:patient'])->group(function () {
    Route::get('/my/appointments', [AppointmentController::class, 'myAppointments'])->name('my.appointments');
    Route::get('/my/payments', [PaymentController::class, 'myPayments'])->name('my.payments');
});

// ---------------------------------------------------
// Admin + Receptionist
// Manage payments
// ---------------------------------------------------
Route::middleware(['auth', 'role:admin,receptionist'])->group(function () {
    Route::resource('payments', PaymentController::class);
});

// ---------------------------------------------------
// Auth routes (Breeze/Fortify)
// ---------------------------------------------------
require __DIR__.'/auth.php';
