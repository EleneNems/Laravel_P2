<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'patient_id' => Patient::inRandomOrder()->first()->id ?? Patient::factory(),
            'doctor_id' => Doctor::inRandomOrder()->first()->id ?? Doctor::factory(),
            'appointment_date' => fake()->dateTimeBetween('-1 month', '+1 month'),
            'status' => fake()->randomElement(['pending', 'approved', 'completed', 'canceled']),
            'notes' => fake()->sentence(),
        ];
    }
}
