<?php namespace App\Classes;
use App\Tbl_account_log;
use App\Tbl_slot_log;

class MLM
{
	public static function account($account_id, $log)
	{
		$insert["account_id"] = $account_id;
		$insert["account_log_details"] = $log;
		$insert["account_log_date"] = Carbon\Carbon::now();
		Tbl_account_log::insert($insert);
	}
	public static function slot($slot_id, $log, $wallet_update)
	{
		$insert["slot_id"] = $slot_id;
		$insert["slot_log_details"] = $log;
		$insert["slot_log_wallet_update"] = $wallet_update;
		$insert["slot_log_date"] = Carbon\Carbon::now();
		Tbl_account_log::insert($insert);
	}
}