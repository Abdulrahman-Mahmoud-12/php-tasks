<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'System Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Regular User
        User::create([
            'name' => 'John Doe',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Categories & Products
        $cat1 = Category::create(['name' => 'Electronics', 'description' => 'Gadgets and hardware']);
        $cat2 = Category::create(['name' => 'Clothing', 'description' => 'Apparel and footwear']);

        Product::create([
            'name' => 'Wireless Mouse',
            'description' => 'Ergonomic optical mouse',
            'price' => 29.99,
            'quantity' => 50,
            'category_id' => $cat1->id,
        ]);

        Product::create([
            'name' => 'Cotton T-Shirt',
            'description' => '100% breathable cotton',
            'price' => 15.00,
            'quantity' => 100,
            'category_id' => $cat2->id,
        ]);
    }
}
