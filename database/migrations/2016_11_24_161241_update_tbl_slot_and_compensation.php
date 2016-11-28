<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblSlotAndCompensation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_slot', function (Blueprint $table)
        {
            $table->tinyInteger('removed_from_gps')->default(0);
        });
    
        Schema::table('tbl_compensation_rank', function (Blueprint $table)
        {
            $table->double('compensation_rank_percentage')->default(0);
        });
        
        
        $update["compensation_rank_percentage"] = 50;
        DB::table("tbl_compensation_rank")->whereIn("compensation_rank_id",["3","4"])->update($update);
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
