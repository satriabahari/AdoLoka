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
        Schema::create('service_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Customer Info (untuk guest checkout)
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');

            // Order Details
            $table->integer('quantity')->default(1);
            $table->unsignedBigInteger('price_per_unit');
            $table->unsignedBigInteger('total_price');
            $table->text('notes')->nullable();

            // Payment
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'expired'])->default('pending');
            $table->string('snap_token')->nullable();
            $table->string('midtrans_order_id')->nullable();
            $table->json('payment_data')->nullable();

            // Order Status
            $table->enum('order_status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
            $table->timestamp('paid_at')->nullable();

            $table->timestamps();

            $table->index(['order_number', 'payment_status']);
            $table->index('midtrans_order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_orders');
    }
};
