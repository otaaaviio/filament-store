<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
            'is_admin' => true,
        ]);

        Order::factory(20)->create(); //a partir desse se cria os outros registros necessários
        //        $products = Product::factory(20)->create();
        //        $users = User::factory(20)->create();

        //        ProductReview::factory(20)
        //            ->recycle($products)
        //            ->recycle($users)
        //            ->create();

        //        ProductsOrder::factory(20)
        //            ->recycle($orders)
        //            ->create();

        //        ProductImage::factory(20)
        //            ->recycle($products)
        //            ->create();
    }
}
