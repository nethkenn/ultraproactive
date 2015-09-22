<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblVoucherHasProductDiscountAmount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('tbl_voucher_has_product', 'product_discount_amount'))
        {
            Schema::table('tbl_voucher_has_product', function (Blueprint $table)
            {
                $table->double('product_discount_amount')->default(0);
            });            
        }
        if (!Schema::hasColumn('tbl_voucher_has_product', 'gc'))
        {
            Schema::table('tbl_voucher_has_product', function (Blueprint $table)
            {
                $table->tinyInteger('gc')->default(0);
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
