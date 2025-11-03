<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->text('description')->nullable();
            $table->string('slug')->unique();

            $table->decimal('price', 12, 2)->default(0);
            $table->string('unit')->nullable();
            $table->string('consultation_link')->nullable();
            $table->boolean('has_brand_identity')->default(false);

            $table->unsignedTinyInteger('revision_max')->default(0);

            $table->unsignedSmallInteger('delivery_days_min')->nullable();
            $table->unsignedSmallInteger('delivery_days_max')->nullable();

            $table->boolean('is_active')->default(true);

            $table->foreignId('category_id')
                ->constrained('service_categories')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('umkm_id')
                ->constrained('umkms')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->index(['is_active', 'category_id', 'user_id', 'umkm_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
