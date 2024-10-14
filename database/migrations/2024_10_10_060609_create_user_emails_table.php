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
        Schema::create('user_emails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('username'); // Foreign key to the users table
            $table->string('email'); // Stores the email address
            $table->boolean('status')->default(true); // Indicates if the email is active (true) or inactive (false)
            $table->timestamps();

            // Create indexes
            $table->index('username'); // Index for the username foreign key
            $table->index('email'); // Index for the email column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_emails', function (Blueprint $table) {
            // Drop indexes before dropping the table
            $table->dropIndex(['username']);
            $table->dropIndex(['email']);
        });

        Schema::dropIfExists('user_emails');
    }
};
