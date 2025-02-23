<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('login_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Stores the user's ID
            $table->string('email')->nullable(); // Stores email in case the user is not found
            $table->string('ip_address'); // Stores the IP address of the login attempt
            $table->string('user_agent')->nullable(); // Stores the user agent (browser info)
            $table->string('status'); // Stores the status of the login (success, failed, error)
            $table->timestamp('logged_at')->nullable(); // When the login attempt occurred
            $table->timestamp('logout_at')->nullable(); // When the user logs out (nullable)
            $table->timestamps();

            // Foreign key relation to the users table (if applicable)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login_logs');
    }
};
