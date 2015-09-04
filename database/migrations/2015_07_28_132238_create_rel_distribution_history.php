<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelDistributionHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rel_distribution_history', function (Blueprint $table) {
            $table->integer('distribution_id')->unsigned();
            $table->integer('slot_id')->unsigned();
            $table->double('group_points');
            $table->double('convert_amount');
            $table->foreign('slot_id')->references('slot_id')->on('tbl_slot');
            $table->foreign('distribution_id')->references('distribution_id')->on('tbl_distribution_history');
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rel_distribution_history');
    }
}
