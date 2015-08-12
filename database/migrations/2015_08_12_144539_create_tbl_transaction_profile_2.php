<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblTransactionProfile2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_transaction_profile'))
        {
            Schema::create('tbl_transaction_profile', function (Blueprint $table)
            {    
                    $table->increments('id');
                    $table->string('profile_name');
                    $table->string('transaction_code');
                    $table->tinyInteger('archived')->default(0);
                  
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
        Schema::drop('tbl_transaction_profile');
    }
}
