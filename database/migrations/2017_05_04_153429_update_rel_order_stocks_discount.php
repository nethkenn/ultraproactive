<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRelOrderStocksDiscount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rel_order_stocks', function (Blueprint $table)
        {
            $table->double('discount')->default(0);
        });
        
        Schema::table('rel_order_stocks_package', function (Blueprint $table)
        {
            $table->double('discount')->default(0);
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
