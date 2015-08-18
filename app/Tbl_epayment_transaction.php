<?php
namespace App;

use Illuminate\Database\Eloquent\Model;


class Tbl_epayment_transaction extends Model 
{





	protected $table = 'tbl_epayment_transaction';
	// protected $primaryKey = 'agentRefNo';
	protected $fillable = [
							'agentRefNo',
							'country',
							'account',

							'transaction',
							'rate_peso',
							'service_charge',

							'amount',
							'total_amount',
							'total_amount_in_country',
							'e_wallet',
							'e_wallet_less_total'
	 						];


	public function scopeTransaction($query)
	{
		return $query->leftJoin('tbl_epayment_transation_code_list','tbl_epayment_transation_code_list.transaction_code', '=', 'tbl_epayment_transaction.transaction');
	}

	public function scopeCurrency($query)
	{
		return $query->leftJoin('tbl_country','tbl_country.country_id', '=', 'tbl_epayment_transaction.country');
	}

	

}