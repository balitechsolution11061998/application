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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('name');
            $table->string('email');
            $table->string('photo')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('whatshapp_no')->nullable();
            $table->string('channel_id')->nullable();
            $table->enum('status',['y','n']);
            $table->enum('all_supplier',['y','n']);
            $table->string('password')->nullable();
            $table->string('link_whatshapps')->nullable();
            $table->string('api_key_whatshapps')->nullable();
            $table->string('link_sync')->nullable();
            $table->integer('region')->nullable();
            $table->text('address')->nullable();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->text('about_us')->nullable();
            $table->string('phone_number',16)->nullable();
            $table->rememberToken();
            $table->timestamps();
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
