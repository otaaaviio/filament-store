<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductReview;
use App\Models\ProductsOrder;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\OrderFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ProductCategorySeeder::class,
            OrderStatusSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'adm@adm.com',
            'is_admin' => true
        ]);

        $orders = Order::factory(20)->create();
        $products = Product::factory(20)->create();
        $users = User::factory(20)->create();

        ProductReview::factory(20)
            ->recycle($products)
            ->recycle($users)
            ->create();

        ProductsOrder::factory(20)
            ->recycle($orders)
            ->recycle($products)
            ->create();

        ProductImage::factory(20)
            ->recycle($products)
            ->create();
    }
}
