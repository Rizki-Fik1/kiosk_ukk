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
    Schema::create('otp_verifications', function (Blueprint $table) {
        $table->id();
        $table->string('phone'); // Tidak FK karena bisa untuk phone yang belum register
        $table->string('otp_code', 6); // 6 digit OTP
        $table->enum('type', ['register', 'login']); // Jenis OTP
        $table->timestamp('expires_at'); // OTP expire time (5 menit)
        $table->timestamp('verified_at')->nullable(); // Kapan diverifikasi
        $table->boolean('is_used')->default(false); // Prevent reuse
        $table->integer('attempts')->default(0); // Track failed attempts
        $table->timestamps();
        
        // Indexes untuk performance
        $table->index(['phone', 'type', 'is_used']);
        $table->index('expires_at');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otp_verifications');
    }
};
