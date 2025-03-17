<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('diff_cost_po', function (Blueprint $table) {
            $table->id(); // Adds an auto-incrementing id column
        });
    }

    public function down()
    {
        Schema::table('diff_cost_po', function (Blueprint $table) {
            $table->dropColumn('id');
        });
    }
};
