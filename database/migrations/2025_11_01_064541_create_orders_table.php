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
        Schema::create('orders', function (Blueprint $t) {
            $t->id();
            $t->string('order_number')->unique();      // INV-...
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Referensi item yang dibeli (polimorfik sederhana)
            $t->string('purchasable_type');            // App\Models\Product atau App\Models\Service
            $t->unsignedBigInteger('purchasable_id');

            // Snapshot info item supaya historis harga/nama tidak berubah
            $t->string('item_name');
            $t->decimal('unit_price', 16, 2);
            $t->unsignedInteger('quantity')->default(1);
            $t->decimal('gross_amount', 16, 2);

            // Status & pembayaran
            $t->string('status')->default('waiting_payment'); // waiting_payment|paid|expired|failed
            $t->string('snap_token')->nullable();
            $t->string('transaction_id')->nullable(); // dari Midtrans
            $t->string('payment_type')->nullable();   // qris|bca_va|gopay|...
            $t->timestamp('paid_at')->nullable();

            $t->json('meta')->nullable();             // catatan tambahan
            $t->timestamps();

            $t->index(['purchasable_type', 'purchasable_id']);
            $t->index(['status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
