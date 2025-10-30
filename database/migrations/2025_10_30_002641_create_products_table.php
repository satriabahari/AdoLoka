<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->text('description')->nullable();

            $table->string('slug')->unique();

            $table->decimal('price', 12, 2)->default(0);
            $table->integer('stock')->default(0);
            $table->boolean('is_active')->default(true);

            $table->foreignId('category_id')
                ->constrained('product_categories')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('umkm_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
