<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblMembershipCodeSale extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_membership_code_sale', function (Blueprint $table) {
            $table->integer('shipping_type')->nullable()->unsigned();
            $table->double('tendered_payment')->default(0);
            $table->double('change')->default(0);


            $table->foreign('shipping_type')
              ->references('id')->on('tbl_shipping_type')
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
        Schema::table('tbl_membership_code_sale', function (Blueprint $table) {
            $table->dropColumn('shipping_type');
            $table->dropColumn('tendered_payment');
            $table->dropColumn('change');
        });
    }
}
