<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ordhead', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_no')->index();
            $table->integer('ship_to')->index();
            $table->integer('supplier')->index();
            $table->integer('terms')->nullable();
            $table->string('status_ind')->nullable();
            $table->date('written_date')->nullable();
            $table->date('not_before_date')->nullable();
            $table->date('not_after_date')->nullable();
            $table->date('approval_date')->nullable();
            $table->string('approval_id')->nullable();
            $table->date('cancelled_date')->nullable();
            $table->string('canceled_id')->nullable();
            $table->integer('cancelled_amt')->nullable();
            $table->double('total_cost')->nullable()->index();
            $table->double('total_retail')->nullable()->index();
            $table->integer('outstand_cost')->nullable();
            $table->double('total_discount')->nullable()->index();
            $table->string('comment_desc')->nullable();
            $table->integer('buyer')->nullable();
            $table->string('status')->nullable();
            $table->text('reason')->nullable();
            $table->date('estimated_delivery_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ordhead');
    }

};
