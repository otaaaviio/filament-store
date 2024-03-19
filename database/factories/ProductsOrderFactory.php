<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductsOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductsOrder>
 */
class ProductsOrderFactory extends Factory
{
    public function definition(): array
    {
        $product = Product::factory()->create();

        return [
            'order_id' => Order::factory(),
            'product_id' => $product->product_id,
            'quantity' => $this->faker->numberBetween(1, $product->quantity_stock),
        ];
    }
}
