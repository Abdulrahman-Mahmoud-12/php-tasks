<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::factory(10)->create();

        $categories = Category::factory(5)->create();

        $products = Product::factory(20)->create([
            'category_id' => fn() => $categories->random()->id,
        ]);

        Order::factory(15)->create([
            'user_id' => fn() => $users->random()->id,
        ])->each(function ($order) use ($products) {
            $randomProducts = $products->random(rand(1, 3));
            foreach ($randomProducts as $product) {
                OrderItem::factory()->create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'price' => $product->price,
                ]);
            }
        });
    }
}