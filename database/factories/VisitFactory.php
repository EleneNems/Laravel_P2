<?php

namespace Database\Factories;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

class VisitFactory extends Factory
{
    public function definition(): array
    {
        return [
            'appointment_id' => Appointment::inRandomOrder()->first()->id ?? Appointment::factory(),
            'diagnosis' => fake()->sentence(),
            'treatment' => fake()->sentence(),
            'prescription' => fake()->optional()->sentence(),
            'visit_date' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
