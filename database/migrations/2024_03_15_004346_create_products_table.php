<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id('product_category_id');
            $table->text('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->text('name');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->integer('quantity_stock');
            $table->foreignId('product_category_id')->constrained('product_categories', 'product_category_id');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('products', function () {
            DB::statement('CREATE UNIQUE INDEX unique_name_when_not_deleted ON "products" (name) WHERE deleted_at IS NULL');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_categories');
    }
};
