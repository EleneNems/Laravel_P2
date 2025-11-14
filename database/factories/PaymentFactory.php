<?php

namespace Database\Factories;

use App\Models\Visit;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'visit_id' => Visit::inRandomOrder()->first()->id ?? Visit::factory(),
            'amount' => fake()->randomFloat(2, 20, 300),
            'payment_method' => fake()->randomElement(['cash', 'card', 'insurance']),
            'status' => fake()->randomElement(['paid', 'unpaid']),
        ];
    }
}
