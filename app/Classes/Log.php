<?php namespace App\Classes;
use App\Tbl_account_log;
use App\Tbl_slot_log;
use App\Tbl_inventory_logs;
use App\Tbl_stockist_log; 
use App\Tbl_e_wallet_log; 
use Carbon;
use App\Tbl_wallet_logs;
use App\Tbl_slot;
use App\Tbl_transaction;
use App\Rel_transaction;
use App\Tbl_admin_log;
use App\Tbl_admin_log_url;
class Log
{
	public static function account($account_id, $log)
	{
		$insert["account_id"] = $account_id;
		$insert["account_log_details"] = $log;
		$insert["account_log_date"] = Carbon\Carbon::now();
		Tbl_account_log::insert($insert);
	}
	
	public static function Admin($account_id,$log,$old = null,$new = null)
	{
		$insert["account_id"] = $account_id;
		$insert["logs"] = $log;
		$insert["created_at"] = Carbon\Carbon::now();
		$insert["old_data"] = $old;
		$insert["new_data"] = $new;
		Tbl_admin_log::insert($insert);
	}

	public static function AdminUrl($account_id,$log)
	{
		$insert["account_id"] = $account_id;
		$insert["logs_url"] = $log;
		$insert["created_at"] = Carbon\Carbon::now();
		Tbl_admin_log_url::insert($insert);
	}

	public static function transaction($insert)
	{
		$insert["transaction_description"] = 		$insert['transaction_description'];
		$insert["transaction_amount"] =			    $insert['transaction_amount'];
		$insert["transaction_discount_percentage"]= $insert['transaction_discount_percentage'];
		$insert["transaction_discount_amount"] = 	$insert['transaction_discount_amount'];
		$insert["transaction_total_amount"] = 		$insert['transaction_total_amount'];
		$insert["transaction_paid"] =				$insert['transaction_paid'];
		$insert["transaction_claimed"] = 			$insert['transaction_claimed'];
		$insert["archived"] =						$insert['archived'];
		$insert["transaction_by"] =			    	$insert['transaction_by'];
		$insert["transaction_to"] = 				$insert['transaction_to'];
		$insert["transaction_payment_type"] = 		$insert['transaction_payment_type'];
		$insert["transaction_by_stockist_id"] = 	$insert['transaction_by_stockist_id'];
		$insert["transaction_to_id"] = 				$insert['transaction_to_id'];
		$insert["extra"] = 							$insert['extra'];
		$insert["voucher_id"] = 					$insert['voucher_id'];
		$insert["earned_pv"] = 						$insert['earned_pv'];
		$insert["created_at"] = 					$insert['created_at'];
		$insert["transaction_slot_id"] = 			$insert['transaction_slot_id'];

		$id = Tbl_transaction::insertGetId($insert);

		return $id;
	}


	public static function transaction_product($insert)
	{
		$insert["transaction_id"]      = $insert['transaction_id'];
		$insert["if_product"]		   = $insert['if_product'];	
		$insert["if_product_package"]  = $insert['if_product_package'];	
		$insert["if_code_pin"] 	       = $insert['if_code_pin'];	
		$insert["product_id"]		   = $insert['product_id'];	
		$insert["product_package_id"]  = $insert['product_package_id'];	
		$insert["code_pin"] 		   = $insert['code_pin'];	
		$insert["transaction_amount"]  = $insert['transaction_amount'];	
		$insert["transaction_qty"] 	   = $insert['transaction_qty'];	
		$insert["transaction_total"]   = $insert['transaction_total'];	
		$insert["rel_transaction_log"] = $insert['rel_transaction_log'];	
		$insert["sub_earned_pv"] 	   = $insert['sub_earned_pv'];	
		$insert["product_discount"] 	   = $insert['product_discount'];
		$insert["product_discount_amount"] 	   = $insert['product_discount_amount'];
		Rel_transaction::insert($insert);
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

	public static function slot_with_flush($slot_id, $logs, $amt, $keycode = "OTHERS",$cause_id,$flush = 0)
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
		$insert["flushed_out"]   = $flush;

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

	public static function inventory_log($account_id,$product_id,$quantity,$log,$amount = 0,$sold = 1)
	{
		$insert["account_id"] = $account_id;
		$insert["log"] = $log;
		$insert["quantity"] = $quantity;
		$insert["product_id"] =$product_id;
		$insert["sold"] = $sold;
		$insert["created_at_date"] = Carbon\Carbon::now();
		$insert["wallet_amount"] = $amount;
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