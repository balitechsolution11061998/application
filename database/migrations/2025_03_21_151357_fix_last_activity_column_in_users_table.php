<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixLastActivityColumnInUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: Add a temporary column to store Unix timestamps
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('last_activity_tmp')->nullable()->after('last_activity');
        });

        // Step 2: Convert existing datetime values to Unix timestamps
        DB::table('users')->select('id', 'last_activity')->orderBy('id')->chunk(100, function ($users) {
            foreach ($users as $user) {
                if ($user->last_activity) {
                    $timestamp = strtotime($user->last_activity);
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update(['last_activity_tmp' => $timestamp]);
                }
            }
        });

        // Step 3: Remove the old column and rename the new column
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_activity');
            $table->renameColumn('last_activity_tmp', 'last_activity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Step 1: Add a temporary column to store datetime values
        Schema::table('users', function (Blueprint $table) {
            $table->datetime('last_activity_tmp')->nullable()->after('last_activity');
        });

        // Step 2: Convert Unix timestamps back to datetime values
        DB::table('users')->select('id', 'last_activity')->orderBy('id')->chunk(100, function ($users) {
            foreach ($users as $user) {
                if ($user->last_activity) {
                    $datetime = date('Y-m-d H:i:s', $user->last_activity);
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update(['last_activity_tmp' => $datetime]);
                }
            }
        });

        // Step 3: Remove the old column and rename the new column
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_activity');
            $table->renameColumn('last_activity_tmp', 'last_activity');
        });
    }
}