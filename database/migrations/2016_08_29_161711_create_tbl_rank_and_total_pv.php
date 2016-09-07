<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblRankAndTotalPv extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_pv_logs', function (Blueprint $table)
        {
            $table->increments('personal_pv_logs_id');
            $table->integer('owner_slot_id')->unsigned();
            $table->double('amount');
            $table->string('detail');
            $table->dateTime('date_created');
            $table->string('type');

            $table->foreign('owner_slot_id')->references('slot_id')->on('tbl_slot')->onDelete('cascade');
        });
        
        Schema::create('tbl_compensation_rank', function (Blueprint $table)
        {
            $table->increments('compensation_rank_id');
            $table->string('compensation_rank_name');
            $table->double('required_group_pv');
            $table->double('required_personal_pv');
            $table->integer('rank_max_pairing');
            $table->integer('required_compensation_rank_id')->unsigned()->nullable();
            $table->integer('required_compensation_rank_amount');
            $table->integer('required_personal_pv_maintenance');
        });
        
        $insert[0]["compensation_rank_name"]                   =  "Regular";          
        $insert[0]["required_group_pv"]                        =  0;     
        $insert[0]["required_personal_pv"]                     =  0;       
        $insert[0]["rank_max_pairing"]                         =  15;    
        $insert[0]["required_compensation_rank_id"]            =  null;                 
        $insert[0]["required_compensation_rank_amount"]        =  0;                     
        $insert[0]["required_personal_pv_maintenance"]         =  0;       
        
        $insert[1]["compensation_rank_name"]                   =  "Silver";          
        $insert[1]["required_group_pv"]                        =  1000;     
        $insert[1]["required_personal_pv"]                     =  500;       
        $insert[1]["rank_max_pairing"]                         =  18;    
        $insert[1]["required_compensation_rank_id"]            =  2;                 
        $insert[1]["required_compensation_rank_amount"]        =  1;                     
        $insert[1]["required_personal_pv_maintenance"]         =  50;   
        
        $insert[2]["compensation_rank_name"]                   =  "Gold";          
        $insert[2]["required_group_pv"]                        =  5000;     
        $insert[2]["required_personal_pv"]                     =  2500;       
        $insert[2]["rank_max_pairing"]                         =  21;    
        $insert[2]["required_compensation_rank_id"]            =  3;                 
        $insert[2]["required_compensation_rank_amount"]        =  1;                     
        $insert[2]["required_personal_pv_maintenance"]         =  100;            
        
        $insert[3]["compensation_rank_name"]                   =  "Diamond";          
        $insert[3]["required_group_pv"]                        =  20000;     
        $insert[3]["required_personal_pv"]                     =  10000;       
        $insert[3]["rank_max_pairing"]                         =  24;    
        $insert[3]["required_compensation_rank_id"]            =  4;                 
        $insert[3]["required_compensation_rank_amount"]        =  1;                     
        $insert[3]["required_personal_pv_maintenance"]         =  200;                 
        
        DB::table("tbl_compensation_rank")->insert($insert);
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
