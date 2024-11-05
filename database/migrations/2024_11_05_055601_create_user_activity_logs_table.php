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
        Schema::create('authentications_monitoring', function (Blueprint $table) {
            $table->id(); // id column as bigint with auto increment and primary key
            $table->bigInteger('user_id')->nullable(); // user_id as unsigned bigint
            $table->string('action_type', 191); // action_type as varchar(191)
            $table->string('browser_name', 191); // browser_name as varchar(191)
            $table->string('platform', 191); // platform as varchar(191)
            $table->string('device', 191); // device as varchar(191)
            $table->string('ip', 191); // ip as varchar(191)
            $table->text('page'); // page as text
            $table->timestamps(); // created_at and updated_at as timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_activity_logs');
    }
};
