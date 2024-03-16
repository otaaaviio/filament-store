<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\ProductReview;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(2),
            'description' => $this->faker->text(255),
            'price' => $this->faker->randomFloat(2, 10, 150),
            'quantity_stock' => $this->faker->numberBetween(2,20),
            'product_category_id' => $this->faker->numberBetween(1,5),
        ];
    }
}
