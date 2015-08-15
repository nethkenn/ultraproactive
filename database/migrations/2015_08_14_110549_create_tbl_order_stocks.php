<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblOrderStocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   

        if (Schema::hasTable('tbl_order_stocks'))
        {

            Schema::create('tbl_order_stocks', function (Blueprint $table)
            {

                $table->increments('order_stocks_id')->unsigned();
                $table->integer('stockist_id')->unsigned();
                $table->integer('stockist_user_id')->unsigned();
                $table->integer('confirmed');
                $table->integer('paid');
                $table->timestamps();
            });
        }
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
