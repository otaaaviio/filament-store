<?php

namespace Database\Seeders;

use App\Enums\OrderStatusEnum;
use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    public function run(): void
    {
        foreach (OrderStatusEnum::getLabels() as $label) {
            OrderStatus::create(['name' => $label]);
        }
    }
}
