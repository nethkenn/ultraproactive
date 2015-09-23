<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblRelTransactionAddDiscount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('rel_transaction', 'product_discount'))
        {
            Schema::table('rel_transaction', function (Blueprint $table)
            {
                $table->double('product_discount')->default(0);
                $table->double('product_discount_amount')->default(0);
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
