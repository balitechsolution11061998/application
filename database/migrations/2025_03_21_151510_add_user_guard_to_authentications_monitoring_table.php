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
        Schema::table('authentications_monitoring', function (Blueprint $table) {
            // Add the 'user_guard' column as a string (VARCHAR)
            $table->string('user_guard', 255)->nullable()->after('device');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('authentications_monitoring', function (Blueprint $table) {
            // Drop the 'user_guard' column if the migration is rolled back
            $table->dropColumn('user_guard');
        });
    }
};
