<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state(['role' => 'patient']),
            'insurance_number' => fake()->optional()->numerify('INS####'),
            'emergency_contact' => fake()->optional()->phoneNumber(),
        ];
    }
}
