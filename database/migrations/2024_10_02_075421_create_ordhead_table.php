<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ordhead', function (Blueprint $table) {
            $table->id();
            $table->string('order_no')->unique();
            $table->string('ship_to')->nullable();
            $table->string('supplier');
            $table->string('terms')->nullable();
            $table->string('status_ind')->nullable();
            $table->date('written_date')->nullable();
            $table->date('not_before_date')->nullable();
            $table->date('not_after_date')->nullable();
            $table->date('approval_date')->nullable();
            $table->string('approval_id')->nullable();
            $table->date('cancelled_date')->nullable();
            $table->unsignedBigInteger('canceled_id')->nullable();
            $table->decimal('cancelled_amt', 15, 2)->nullable();
            $table->decimal('total_cost', 15, 2)->nullable();
            $table->decimal('total_retail', 15, 2)->nullable();
            $table->decimal('outstand_cost', 15, 2)->nullable();
            $table->decimal('total_discount', 15, 2)->nullable();
            $table->text('comment_desc')->nullable();
            $table->string('buyer')->nullable();
            $table->string('status')->default('Progress');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ordhead');
    }

};
