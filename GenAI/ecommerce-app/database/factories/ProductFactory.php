<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'description' => fake()->sentences(3, true),
            'price' => fake()->randomFloat(2, 10, 999.99),
            'quantity' => fake()->numberBetween(0, 150),
            'category_id' => Category::factory(),
        ];
    }
}
