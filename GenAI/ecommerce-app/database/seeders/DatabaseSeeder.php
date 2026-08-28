<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        $admin = User::create([
            'name' => 'System Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $defaultUser = User::create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $users = User::factory(15)->create(['role' => 'user']);
        $allUsers = $users->concat([$defaultUser]);

        $categories = Category::factory(6)->create();

        $products = collect();
        foreach ($categories as $category) {
            $createdProducts = Product::factory(8)->create([
                'category_id' => $category->id,
            ]);
            $products = $products->concat($createdProducts);
        }

        foreach ($allUsers as $user) {
            $orderCount = rand(1, 3);

            for ($i = 0; $i < $orderCount; $i++) {
                $order = Order::create([
                    'user_id' => $user->id,
                    'created_at' => fake()->dateTimeBetween('-3 months', 'now'),
                ]);

                $randomProducts = $products->random(rand(1, 4));

                foreach ($randomProducts as $product) {
                    $qty = rand(1, 3);
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $qty,
                        'price' => $product->price,
                    ]);
                }
            }
        }
    }
}