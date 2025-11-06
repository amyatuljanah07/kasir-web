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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['percentage', 'fixed']); // diskon persen atau nominal
            $table->decimal('value', 15, 2); // nilai diskon
            $table->decimal('min_purchase', 15, 2)->default(0); // min pembelian
            $table->decimal('max_discount', 15, 2)->nullable(); // max potongan (untuk percentage)
            $table->integer('usage_limit')->nullable(); // limit penggunaan total
            $table->integer('usage_per_user')->default(1); // limit per user
            $table->date('valid_from');
            $table->date('valid_until');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_member_only')->default(false); // khusus member
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
