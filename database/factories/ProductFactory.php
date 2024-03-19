<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductReview;
use App\Models\User;
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
            'quantity_stock' => $this->faker->numberBetween(2, 20),
            'product_category_id' => $this->faker->numberBetween(1, 5),
        ];
    }

    public function configure(): ProductFactory|Factory
    {
        return $this->afterCreating(function (Product $product) {
            for ($i = 0; $i < 2; $i++) {
                $image = $this->faker->image(storage_path('app/public/images'), 640, 480, null, false);
                $imagePath = 'public/storage/images/'.$image;
                ProductImage::factory()->create([
                    'product_id' => $product->product_id,
                    'path' => $imagePath,
                ]);

                $product->addMedia($imagePath)->toMediaCollection();

                ProductReview::factory()->create([
                    'product_id' => $product->product_id,
                    'user_id' => User::factory(),
                    'review' => $this->faker->text(255),
                    'rating' => $this->faker->numberBetween(1, 5),
                ]);
            }
        });
    }
}
