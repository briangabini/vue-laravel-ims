<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.     */    public function up(): void
    {
        // 1. Create tables without foreign key dependencies first
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
        });

        Schema::create('security_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question_text')->unique();
        });

        // 2. Modify the existing users table
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('password_changed_at')->nullable();
        });

        // 3. Create tables that depend on the users table
        Schema::create('password_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('password_hash');
            $table->timestamp('created_at');
        });

        Schema::create('login_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('ip_address');
            $table->boolean('successful');
            $table->timestamp('logged_in_at');
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('status');
            $table->decimal('total_price', 10, 2);
            $table->timestamps();
        });

        // 4. Create tables that depend on other new tables
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2);
            $table->integer('stock');
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('user_security_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('security_question_id')->constrained()->cascadeOnDelete();
            $table->string('answer_hash');
            $table->timestamps();
        });

        // 5. Create the pivot table last as it depends on two other tables
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity');
            $table->decimal('price_per_unit', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.     * This must be done in the exact reverse order of the 'up' method.     */    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('user_security_answers');
        Schema::dropIfExists('products');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('login_attempts');
        Schema::dropIfExists('password_histories');
        Schema::dropIfExists('security_questions');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('roles');

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn(['role_id', 'password_changed_at']);
        });
    }
};
