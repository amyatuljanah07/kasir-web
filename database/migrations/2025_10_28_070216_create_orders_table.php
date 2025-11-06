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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 50)->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('total', 15, 2);
            $table->enum('payment_method', ['virtual_card', 'balance', 'cash', 'transfer'])->default('balance');
            $table->enum('status', ['pending', 'paid', 'verified', 'completed', 'cancelled'])->default('pending');
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null'); // Pegawai yang verifikasi
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
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
