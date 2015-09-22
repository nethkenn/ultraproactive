<?php namespace App\Classes;
use App\Tbl_account_log;
use App\Tbl_slot_log;
use App\Tbl_inventory_logs;
use App\Tbl_stockist_log; 
use App\Tbl_e_wallet_log; 
use Carbon;
use App\Tbl_wallet_logs;
use App\Tbl_slot;
class Log
{
	public static function account($account_id, $log)
	{
		$insert["account_id"] = $account_id;
		$insert["account_log_details"] = $log;
		$insert["account_log_date"] = Carbon\Carbon::now();
		Tbl_account_log::insert($insert);
	}
	
	// public static function slot($slot_id, $log, $wallet_update, $log_key = "OTHERS")
	// {
	// 	$insert["slot_id"] = $slot_id;
	// 	$insert["slot_log_details"] = $log;
	// 	$insert["slot_log_wallet_update"] = $wallet_update;
	// 	$insert["slot_log_date"] = Carbon\Carbon::now();
	// 	$insert["slot_log_key"] = $log_key;
	// 	Tbl_slot_log::insert($insert);
	// }

	public static function slot($slot_id, $logs, $amt, $keycode = "OTHERS",$cause_id,$gc = 0)
	{
		$account_id 			 = Tbl_slot::where('slot_id',$slot_id)->first();
		$account_id              = $account_id->slot_owner;
		$insert["slot_id"]       = $slot_id;
		$insert["logs"] 	     = $logs;
		$insert["wallet_amount"] = $amt;
		$insert["keycode"]       = $keycode;
		$insert["cause_id"]      = $cause_id;
		$insert["account_id"]    = $account_id;
		$insert["created_at"]    = Carbon\Carbon::now();
		if($gc == 1)
		{
			$insert["wallet_type"] = "GC";
		}
		Tbl_wallet_logs::insert($insert);	
	}

	// public static function wallet_slot($amount,$keycode,$slot_id,$cause_id,$account_id,$logs)
	// {
	// 	$insert["wallet_amount"] = $amount;
	// 	$insert["keycode"]       = $keycode;
	// 	$insert["slot_id"]       = $slot_id;
	// 	$insert["cause_id"]      = $cause_id;
	// 	$insert["account_id"]    = $account_id;
	// 	$insert["logs"] 	     = $logs;
	// 	$insert["created_at"]    = Carbon\Carbon::now();
	// 	Tbl_wallet_logs::insert($insert);		
	// }

	public static function inventory_log($account_id,$product_id,$quantity,$log)
	{
		$insert["account_id"] = $account_id;
		$insert["wallet_amount"] = $log;
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