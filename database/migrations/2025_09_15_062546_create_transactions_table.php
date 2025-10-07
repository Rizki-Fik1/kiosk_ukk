<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // Relasi ke sales (nota penjualan)
            $table->foreignId('sale_id')->constrained('sales')->onDelete('cascade');

            // ID unik dari payment gateway (Midtrans, dll.)
            $table->string('reference')->unique();

            // Jumlah pembayaran (biasanya = sales.total_amount, 
            // tapi bisa berbeda kalau ada refund/discount dll.)
            $table->decimal('amount', 10, 2);

            // Status transaksi
            $table->enum('status', [
                'pending',    // order dibuat tapi belum dibayar
                'paid',       // sukses dibayar
                'failed',     // gagal dibayar
                'refunded'    // sudah dikembalikan
            ])->default('pending');

            // Metode pembayaran (cash, qris, gopay, bank_transfer, dll.)
            $table->string('payment_method')->nullable();

            // Data tambahan dari gateway (misalnya response JSON Midtrans)
            $table->json('payload')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
