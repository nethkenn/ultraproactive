
<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_admin', function (Blueprint $table)
        {

            $table->increments('admin_id');
            $table->integer('account_id')->unsigned();
            $table->integer('admin_position_id')->unsigned();

                        $table  ->foreign('account_id')
                    ->references('account_id')
                    ->on('tbl_account')
                    ->onDelete('cascade');


                                    $table  ->foreign('admin_position_id')
                    ->references('admin_position_id')
                    ->on('tbl_admin_position')
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
        Schema::drop("tbl_admin");
    }
}