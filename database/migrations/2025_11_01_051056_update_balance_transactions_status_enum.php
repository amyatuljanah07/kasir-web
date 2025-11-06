<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update ENUM to include 'rejected' status
        DB::statement("ALTER TABLE balance_transactions MODIFY COLUMN status ENUM('pending', 'completed', 'failed', 'rejected') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original ENUM
        DB::statement("ALTER TABLE balance_transactions MODIFY COLUMN status ENUM('pending', 'completed', 'failed') DEFAULT 'pending'");
    }
};
