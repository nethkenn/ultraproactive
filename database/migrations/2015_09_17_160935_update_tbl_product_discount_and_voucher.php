<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblProductDiscountAndVoucher extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasColumn('tbl_voucher_has_product', 'product_discount'))
        {
            Schema::table('tbl_voucher_has_product', function (Blueprint $table)
            {
                $table->double('product_discount')->default(0);
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
