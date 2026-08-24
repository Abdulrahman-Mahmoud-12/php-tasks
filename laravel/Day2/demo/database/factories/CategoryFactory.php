<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement(['Electronics', 'Clothing', 'Books', 'Home & Kitchen', 'Sports']),
            'description' => fake()->sentence(),
        ];
    }
}