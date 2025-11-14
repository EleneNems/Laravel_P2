<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Visit;
use App\Models\Payment;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ADMIN USER
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        // Doctors
        Doctor::factory(5)->create();

        // Patients
        Patient::factory(20)->create();

        // Appointments
        Appointment::factory(50)->create();

        // Visits (only for completed appointments ideally)
        Visit::factory(30)->create();

        // Payments
        Payment::factory(30)->create();
    }
}
