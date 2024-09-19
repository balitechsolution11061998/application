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
        Schema::create('region', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Region name
            $table->string('region_code'); // Region name
            $table->timestamps(); // Created_at and updated_at timestamps
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // User's full name
            $table->string('username'); // Unique username for user login
            $table->string('email'); // Unique email address for login
            $table->string('profile_picture')->nullable(); // Optional profile picture URL
            $table->timestamp('email_verified_at')->nullable(); // Email verification timestamp
            $table->string('password'); // Password for login (hashed)
            $table->string('password_show')->nullable(); // Optional: store password in plaintext (not recommended)
            $table->string('phone_number')->nullable();
            $table->rememberToken(); // Token for "remember me" functionality
            $table->foreignId('region_id')->constrained('region')->onDelete('cascade'); // Cascade on delete
            $table->text('address')->nullable();
            $table->timestamps(); // Created_at and updated_at timestamps

            // Adding indices for faster lookups
            $table->index('email');
            $table->index('username');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
