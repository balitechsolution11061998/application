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
            $table->string('email', 191)->unique(); // Email (unique for users)
            $table->string('photo', 191)->nullable(); // Profile photo URL
            $table->timestamp('email_verified_at')->nullable(); // Email verification timestamp
            $table->string('whatshapp_no', 191)->nullable(); // WhatsApp number
            $table->string('channel_id', 191)->nullable(); // Channel ID
            $table->enum('status', ['y', 'n']); // User status
            $table->enum('all_supplier', ['y', 'n']); // All supplier flag
            $table->string('password', 191)->nullable(); // Hashed password
            $table->string('password_show', 255)->nullable(); // Plaintext password (if required, but not recommended)
            $table->string('link_whatshapps', 191)->nullable(); // WhatsApp link
            $table->string('api_key_whatshapps', 191)->nullable(); // WhatsApp API key
            $table->string('link_sync', 191)->nullable(); // Synchronization link
            $table->unsignedBigInteger('region')->nullable(); // Foreign key to region table
            $table->text('address')->nullable(); // Address
            $table->double('latitude')->nullable(); // Latitude
            $table->double('longitude')->nullable(); // Longitude
            $table->text('about_us')->nullable(); // About us section
            $table->string('phone_number', 16)->nullable(); // Phone number
            $table->string('remember_token', 100)->nullable(); // Remember token
            $table->integer('login_attempts')->default(0); // Login attempts count
            $table->timestamp('last_activity')->nullable(); // Last activity timestamp
            $table->string('profile_picture')->nullable(); // Profile picture
            $table->text('supplier_id')->nullable(); // Supplier IDs
            $table->text('supplier_names')->nullable(); // Supplier names
            $table->date('suppliers_added_at')->nullable(); // Suppliers added timestamp
            $table->timestamps(); // Created at and updated at timestamps
            $table->softDeletes(); // Adds `deleted_at` column for soft deletes

            // OAuth fields
            $table->string('oauth_provider', 50)->nullable(); // OAuth provider (e.g., Google, Facebook)
            $table->string('oauth_id', 191)->nullable(); // OAuth ID
            $table->string('oauth_token', 255)->nullable(); // OAuth token
            $table->string('oauth_refresh_token', 255)->nullable(); // OAuth refresh token
            $table->timestamp('oauth_token_expires_at')->nullable(); // OAuth token expiration timestamp

            // Adding indices for faster lookups
            $table->index('email');
            $table->index('username');

            // Foreign key constraints
            $table->foreign('region')->references('id')->on('region')->onDelete('cascade');
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
