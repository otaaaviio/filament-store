<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->text('name');
            $table->text('email');
            $table->text('email_verified_at')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->text('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes()->nullable();
        });

        Schema::table('users', function () {
            DB::statement('CREATE UNIQUE INDEX unique_email_when_not_deleted ON "users" (email) WHERE deleted_at IS NULL');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::table('users', function () {
            DB::statement('DROP INDEX unique_email_when_not_deleted');
        });
        Schema::dropIfExists('password_reset_tokens');
    }
};
