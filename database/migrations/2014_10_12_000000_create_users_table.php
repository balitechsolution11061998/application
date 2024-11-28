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
            $table->bigIncrements('id'); // Primary key
            $table->string('username', 191); // Username
            $table->string('name', 191); // Full name
            $table->string('email', 191); // Email
            $table->string('photo', 191)->nullable(); // Photo
            $table->timestamp('email_verified_at')->nullable(); // Email verified timestamp
            $table->string('whatshapp_no', 191)->nullable(); // WhatsApp number
            $table->string('channel_id', 191)->nullable(); // Channel ID
            $table->enum('status', ['y', 'n']); // Status
            $table->enum('all_supplier', ['y', 'n']); // All supplier flag
            $table->string('password', 191)->nullable(); // Password
            $table->string('password_show', 255)->nullable(); // Password (plaintext)
            $table->string('link_whatshapps', 191)->nullable(); // WhatsApp link
            $table->string('api_key_whatshapps', 191)->nullable(); // WhatsApp API key
            $table->string('link_sync', 191)->nullable(); // Synchronization link
            $table->unsignedBigInteger('region')->nullable(); // Foreign key to region
            $table->text('address')->nullable(); // Address
            $table->double('latitude')->nullable(); // Latitude
            $table->double('longitude')->nullable(); // Longitude
            $table->text('about_us')->nullable(); // About us section
            $table->string('phone_number', 16)->nullable(); // Phone number
            $table->string('remember_token', 100)->nullable(); // Remember token
            $table->integer('login_attempts')->nullable(); // Login attempts
            $table->integer('last_activity')->nullable(); // Last activity timestamp
            $table->string('profile_picture')->nullable(); // Remember token
            $table->timestamps(); // Created at and updated at timestamps

            // Adding soft deletes
            $table->softDeletes(); // Adds `deleted_at` column

            // Adding indices for faster lookups
            $table->index('email');
            $table->index('username');

            // Foreign key for `region`
            $table->foreign('region')->references('id')->on('region')->onDelete('cascade'); // Cascade on delete
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
