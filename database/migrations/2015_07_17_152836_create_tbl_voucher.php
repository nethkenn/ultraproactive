<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblVoucher extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_voucher', function (Blueprint $table) {
            $table->integer('slot_id')->unsigned()->nullable();
            $table->integer('account_id')->unsigned()->nullable();
            $table->integer('or_number')->unsigned()->nullable();
            $table->increments('voucher_id');
            $table->string('voucher_code');
            $table->tinyInteger('claimed')->default(0);
            $table->string('status')->default('unclaimed');
            $table->double('discount');
            $table->double('total_amount');
            $table->tinyInteger('payment_mode')->default(0);
            $table->integer('processed_by')->unsigned()->nullable();
            $table->string('processed_by_name')->nullable();
            $table->timestamps(); 
             
            $table->foreign('processed_by')
                ->references('admin_id')
                ->on('tbl_admin')
                ->onDelete('cascade');

            $table->foreign('slot_id')
                ->references('slot_id')
                ->on('tbl_slot')
                ->onDelete('cascade');

            $table->foreign('account_id')
                ->references('account_id')
                ->on('tbl_account')
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
        Schema::drop('tbl_voucher');
    }
}
