<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblServiceCharge extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_service_charge', function (Blueprint $table) {
            $table->increments('service_charge_id');
            $table->string('service_charge_name');
            $table->double('value');
            $table->integer('currency')->unsigned();
            $table->tinyInteger('archived')->default(0);
            $table->timestamps();

            $table->foreign('currency')
              ->references('currency_id')->on('tbl_exchange_rate')
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
        Schema::drop('tbl_service_charge');
    }
}
