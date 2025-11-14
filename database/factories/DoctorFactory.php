<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state(['role' => 'doctor']),
            'specialization' => fake()->randomElement([
                'Cardiology', 'Dermatology', 'Neurology', 'Orthopedics', 'Pediatrics'
            ]),
            'room_number' => fake()->optional()->numberBetween(100, 500),
        ];
    }
}
