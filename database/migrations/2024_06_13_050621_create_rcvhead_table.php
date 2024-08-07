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

        Schema::create('rcvhead', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('receive_no');
            $table->date('receive_date')->nullable();
            $table->date('created_date')->nullable();
            $table->string('receive_id', 191)->collation('utf8mb4_unicode_ci')->nullable();
            $table->integer('order_no')->nullable();
            $table->string('ref_no', 191)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('order_type', 191)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('status_ind', 191)->collation('utf8mb4_unicode_ci')->nullable();
            $table->date('approval_date')->nullable();
            $table->string('approval_id', 191)->collation('utf8mb4_unicode_ci')->nullable();
            $table->integer('store')->nullable();
            $table->string('store_name', 191)->collation('utf8mb4_unicode_ci')->nullable();
            $table->integer('supplier')->nullable();
            $table->string('sup_name', 191)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('comment_desc', 191)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('status', 191)->collation('utf8mb4_unicode_ci')->nullable();
            $table->bigInteger('sub_total')->nullable();
            $table->bigInteger('sub_total_vat_cost')->nullable();
            $table->double('average_service_level')->nullable();;
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rcvhead');
    }
};
