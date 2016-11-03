<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblSlotCurrentRank extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_slot', function (Blueprint $table)
        {
            $table->integer('current_rank')->default(1)->unsigned();
            $table->foreign('current_rank')->references('compensation_rank_id')->on('tbl_compensation_rank')->onDelete('cascade');           
            
            $table->integer('next_month_rank')->default(1)->unsigned()->nullable();
            $table->foreign('next_month_rank')->references('compensation_rank_id')->on('tbl_compensation_rank')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
