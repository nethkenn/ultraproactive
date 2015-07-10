<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblAccount extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_account', function(Blueprint $table)
		{
			$table->increments('account_id');
			$table->string('account_name');
			$table->string('account_email');
			$table->string('account_username');
			$table->string('account_contact_number');
			$table->integer('account_country_id');
			$table->dateTime('account_date_created');
			$table->text('account_password');
			$table->text('custom_field_value');
			$table->string('account_created_from', 40)->default('Back Office');
            $table->integer('admin_id')->unsigned();
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
		Schema::drop('tbl_account');
	}

}
