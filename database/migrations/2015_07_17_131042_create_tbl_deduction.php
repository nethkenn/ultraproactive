<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblDeduction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_deduction', function (Blueprint $table) {
            $table->increments('deduction_id');
            $table->string('deduction_label');
            $table->tinyInteger('archived')->default(0);
            $table->string('target_country');
            $table->double('deduction_amount');
            $table->tinyInteger('percent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tbl_deduction');
    }
}
