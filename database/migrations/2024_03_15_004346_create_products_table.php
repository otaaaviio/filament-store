<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products_categories', function (Blueprint $table) {
            $table->id('product_category_id');
            $table->text('name');
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->text('name');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->integer('quantity_stock');
            $table->foreignId('product_category_id')->constrained('products_categories', 'product_category_id', );
            $table->timestamps();
            $table->softDeletes()->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('products_categories');
    }
};
