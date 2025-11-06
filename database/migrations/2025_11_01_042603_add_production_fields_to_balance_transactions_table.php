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
        Schema::table('balance_transactions', function (Blueprint $table) {
            $table->string('proof_of_payment')->nullable()->after('reference_number'); // Bukti transfer
            $table->foreignId('verified_by')->nullable()->after('status')->constrained('users')->onDelete('set null'); // Admin yang verifikasi
            $table->string('rejection_reason')->nullable()->after('verified_by'); // Alasan reject
            $table->timestamp('verified_at')->nullable()->after('rejection_reason'); // Waktu verifikasi
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('balance_transactions', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropColumn(['proof_of_payment', 'verified_by', 'rejection_reason', 'verified_at']);
        });
    }
};
