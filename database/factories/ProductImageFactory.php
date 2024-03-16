<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductImage>
 */
class ProductImageFactory extends Factory
{
    public function definition(): array
    {
        $filePath = storage_path('app/public/images');

        return [
            'product_id' => Product::factory(),
            'path' => $this->faker->image($filePath, 640, 480, null, false),
        ];
    }
}
