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
        Schema::create('membership_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nova, Stellar, Galaxy
            $table->string('slug')->unique(); // nova, stellar, galaxy
            $table->decimal('min_spending', 15, 2)->default(0); // minimum total belanja
            $table->decimal('discount_rate', 5, 2)->default(0); // diskon dalam persen
            $table->integer('points_multiplier')->default(1); // pengali poin
            $table->text('benefits')->nullable(); // JSON atau text benefits
            $table->string('badge_color')->default('#gray'); // warna badge
            $table->integer('order')->default(0); // urutan level
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_levels');
    }
};
