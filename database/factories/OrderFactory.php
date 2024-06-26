<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\ProductsOrder;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'order_status_id' => $this->faker->randomElement([1, 2, 3, 6]),
        ];
    }

    public function configure(): OrderFactory
    {
        return $this->afterCreating(function (Order $order) {
            ProductsOrder::factory()->create([
                'order_id' => $order->order_id,
            ]);
        });
    }
}
