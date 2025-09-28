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
        Schema::create('stock_adjustment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // jika product dihapus, adjustment ikut terhapus
            $table->enum('type', ['increase', 'decrease']); // tambah / kurangi stok
            $table->integer('quantity');
            $table->text('reason')->nullable(); // alasan adjustment, misal "barang rusak"
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // admin / kasir yang buat adjustment
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_adjustment');
    }
};
