<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblMembershipCodeSaleAddCodeType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_membership_code_sale', function (Blueprint $table) {
            $table->integer('code_type_id')->unsigned()->nullable();


            $table->foreign('code_type_id')
              ->references('code_type_id')->on('tbl_code_type')
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
            $table->dropColumn('code_type_id');
        });
    }
}
