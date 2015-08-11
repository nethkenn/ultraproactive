<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblInventoryLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_inventory_logs', function (Blueprint $table) {
            $table->integer('account_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('quantity');
            $table->string('log');

            $table->foreign('account_id')
              ->references('account_id')->on('tbl_account')
              ->onDelete('cascade');

            $table->foreign('product_id')
              ->references('product_id')->on('tbl_product')
              ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::drop('tbl_stockist_inventory');
    }
}
