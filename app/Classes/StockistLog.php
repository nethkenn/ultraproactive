<?php namespace App\Classes;
use App\Tbl_account_log;
use App\Tbl_slot_log;
use App\Tbl_transaction;
use App\Rel_transaction; 
use Carbon;

class StockistLog
{
	public static function transaction($process,$amount,$discountp,$discounta,$total,$paid = 0,$claimed = 0,$transaction_by,$transaction_to,$transaction_payment_type,$transaction_by_stockist_id,$transaction_to_id,$extra,$voucher = NULL,$issue = NULL,$remarks="")
	{
		if($voucher == NULL)
		{
			$voucher = NULL;
		}
		
		$insert["transaction_description"] = $process;
		$insert["transaction_amount"] = $amount;
		$insert["transaction_discount_percentage"] = $discountp;
		$insert["transaction_discount_amount"] = $discounta;
		$insert["transaction_total_amount"] = $total;
		$insert["transaction_paid"] = $paid;
		$insert["transaction_claimed"] = $claimed;
		$insert["transaction_by"] = $transaction_by;
		$insert["transaction_to"] = $transaction_to;
		$insert["transaction_payment_type"] = $transaction_payment_type;
		$insert["transaction_by_stockist_id"] = $transaction_by_stockist_id;
		$insert["transaction_to_id"] = $transaction_to_id;
		$insert["extra"] = $extra;
		$insert["voucher_id"] = $voucher;
		$insert["created_at"] = Carbon\Carbon::now();
		$insert["issued_stockist_id"] = $issue;
		$insert["transaction_remark"] = $remarks;

		$id = Tbl_transaction::insertGetId($insert);
		return $id;
	}

	public static function relative($transaction_id,$if_product=0,$if_product_package = 0,$if_code_pin = 0,$product_id,$product_package_id,$code_pin,$transaction_amount,$log,$transaction_qty,$transaction_total,$prod_discount_insert = 0,$prod_discount_insert_amount = 0)
	{
		$insert["transaction_id"] = $transaction_id;

		$insert["if_product"] = $if_product;
		$insert["if_product_package"] = $if_product_package;
		$insert["if_code_pin"] = $if_code_pin;

		$insert["product_id"] = $product_id;
		$insert["product_package_id"] = $product_package_id;
		$insert["code_pin"] = $code_pin;

		$insert["transaction_amount"]  = $transaction_amount;
		$insert["transaction_qty"]  = $transaction_qty;
		$insert["transaction_total"]  = $transaction_total;

		$insert["rel_transaction_log"] = $log;
		$insert["product_discount_amount"] = $prod_discount_insert_amount;
		$insert["product_discount"] 	   = $prod_discount_insert;

		$id = Rel_transaction::insertGetId($insert);
	}
	
}