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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // siapa kasir/admin yang mencatat transaksi
            $table->string('customer_name')->nullable(); // opsional, kadang pembeli tidak dicatat
            $table->decimal('total_amount', 12, 2);
            $table->string('payment_method')->default('cash'); // cash, qris, dll
            $table->enum('status', ['pending', 'paid', 'refunded', 'canceled'])->default('pending');
            $table->string('midtrans_order_id')->nullable(); // kalau pakai Midtrans
            $table->date('sale_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
