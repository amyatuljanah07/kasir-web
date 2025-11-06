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
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('balance', 15, 2)->default(0)->after('is_active');
            $table->date('birthdate')->nullable()->after('balance');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('birthdate');
            $table->string('profile_photo')->nullable()->after('gender');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['balance', 'birthdate', 'gender', 'profile_photo']);
        });
    }
};
