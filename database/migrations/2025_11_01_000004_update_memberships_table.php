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
        Schema::table('memberships', function (Blueprint $table) {
            $table->foreignId('membership_level_id')->nullable()->after('user_id')->constrained('membership_levels')->onDelete('set null');
            $table->decimal('total_spending', 15, 2)->default(0)->after('membership_level_id');
            $table->integer('points')->default(0)->after('total_spending');
            $table->boolean('is_active')->default(true)->after('points');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('memberships', function (Blueprint $table) {
            $table->dropForeign(['membership_level_id']);
            $table->dropColumn(['membership_level_id', 'total_spending', 'points', 'is_active']);
        });
    }
};
