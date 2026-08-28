<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'Electronics', 'Clothing', 'Books', 'Home & Kitchen', 
                'Sports & Outdoors', 'Beauty & Personal Care', 'Toys & Games'
            ]),
            'description' => fake()->paragraph(),
        ];
    }
}
