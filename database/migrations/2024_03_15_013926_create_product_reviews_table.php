<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id('product_review_id');
            $table->foreignId('product_id')->constrained('products', 'product_id');
            $table->foreignId('user_id')->constrained('users', 'user_id');
            $table->text('review');
            $table->integer('rating');
            $table->timestamps();
            $table->softDeletes()->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_reviews');
    }
};
