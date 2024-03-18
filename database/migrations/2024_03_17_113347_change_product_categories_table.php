<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('product_categories', function () {
            DB::statement('CREATE UNIQUE INDEX unique_category_when_not_deleted ON "product_categories" (name) WHERE deleted_at IS NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_categories', function () {
            DB::statement('DROP INDEX unique_category_when_not_deleted');
        });
    }
};
