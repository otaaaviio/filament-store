<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductCategory::create(['name' => 'Eletrônicos']);
        ProductCategory::create(['name' => 'Vestuário']);
        ProductCategory::create(['name' => 'Canecos']);
        ProductCategory::create(['name' => 'Tirantes']);
        ProductCategory::create(['name' => 'Equipamentos']);
    }
}
