<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_orders', function (Blueprint $table) {
            $table->id();

            // Nomor order internal
            $table->string('order_number', 30)->unique();

            // Order ID yang dikirim ke Midtrans
            $table->string('midtrans_order_id', 60)->unique();

            // Relasi
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            // Detail transaksi
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('price_per_unit', 15, 2);
            $table->decimal('total_amount', 15, 2);

            // Data pembeli
            $table->string('customer_name', 150);
            $table->string('customer_email', 191);
            $table->string('customer_phone', 30);
            $table->string('notes')->nullable();

            // Status pembayaran
            $table->string('payment_status', 20)->default('pending'); // pending, paid, failed, expired
            $table->string('payment_type', 50)->nullable(); // contoh: gopay, qris, bank_transfer
            $table->timestamp('paid_at')->nullable();

            // Token Snap & response
            $table->string('snap_token', 100)->nullable();
            $table->json('midtrans_response')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_orders');
    }
};
