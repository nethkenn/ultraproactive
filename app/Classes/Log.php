<?php namespace App\Classes;
use App\Tbl_account_log;
use App\Tbl_slot_log;
use App\Tbl_inventory_logs;
use App\Tbl_stockist_log; 
use App\Tbl_e_wallet_log; 
use Carbon;

class Log
{
	public static function account($account_id, $log)
	{
		$insert["account_id"] = $account_id;
		$insert["account_log_details"] = $log;
		$insert["account_log_date"] = Carbon\Carbon::now();
		Tbl_account_log::insert($insert);
	}
	
	public static function slot($slot_id, $log, $wallet_update, $log_key = "OTHERS")
	{
		$insert["slot_id"] = $slot_id;
		$insert["slot_log_details"] = $log;
		$insert["slot_log_wallet_update"] = $wallet_update;
		$insert["slot_log_date"] = Carbon\Carbon::now();
		$insert["slot_log_key"] = $log_key;
		Tbl_slot_log::insert($insert);
	}

	public static function inventory_log($account_id,$product_id,$quantity,$log)
	{
		$insert["account_id"] = $account_id;
		$insert["log"] = $log;
		$insert["quantity"] = $quantity;
		$insert["product_id"] =$product_id;
		Tbl_inventory_logs::insert($insert);
	}


	public static function e_wallet($account, $log, $e_wallet_update, $e_wallet_log_key = "OTHERS")
	{
		$insert["account"] = $account;
		$insert["e_wallet_details"] = $log;
		$insert["e_wallet_update"] = $e_wallet_update;
		// $insert["created_at"] = Carbon\Carbon::now();
		$insert["e_wallet_log_key"] = $e_wallet_log_key;
		Tbl_e_wallet_log::insert($insert);
	}

	public static function stockist($id,$userid,$log)
	{
		$insert["stockist_id"] = $id;
		$insert["stockist_user_id"] = $userid;
		$insert["stockist_log"] =$log;
		Tbl_stockist_log::insert($insert);
	}

}