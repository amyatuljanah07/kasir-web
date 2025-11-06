<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('product_variants', function (Blueprint $table) {
        $table->id();
        $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
        $table->string('variant_name'); // misal: 250ml, 500ml, 1L
        $table->string('barcode')->unique();
        $table->integer('stock')->default(0);
        $table->decimal('price', 10, 2);
        $table->decimal('discount', 10, 2)->default(0);
        $table->decimal('cost_price', 10, 2);
        $table->date('expiry_date')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
