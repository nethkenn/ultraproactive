<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblFaq extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_faq', function (Blueprint $table)
        {
            $table->increments('faq_id');
            $table->string('faq_title');
            $table->text('faq_content');
            $table->string('faq_type');
            $table->timestamps();
            $table->tinyInteger('archived')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tbl_faq');
    }
}
