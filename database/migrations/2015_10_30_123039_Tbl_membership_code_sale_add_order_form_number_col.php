<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblMembershipCodeSaleAddOrderFormNumberCol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_membership_code_sale', function (Blueprint $table) {
            $table->string('order_form_number')->nullable();
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
            $table->dropColumn('order_form_number');
        });
    }
}
