<?php namespace App\Http\Controllers;

use App\Tbl_voucher;
use App\Tbl_voucher_has_product;
use Request;
use App\Tbl_account;
use App\Classes\Customer;
class MemberVoucherController extends MemberController
{
	public function index()
	{

		$data['_voucher'] = Tbl_voucher::all();

		// dd($data['voucher'] );



        return view('member.voucher' , $data);
	}


	public function showVoucherProduct()
	{

		$customer_id = Customer::info()->account_id;


		$voucher_id = Request::input('voucher_id');
		$voucher = Tbl_voucher::where('voucher_id',$voucher_id)->first();
		if($customer_id != $voucher->account_id)
		{
			return '<div class="col-md=12 alert alert-danger">Forbidden.<div>';
		}
		$account = Tbl_account::where('account_id', $voucher->account_id)->country()->first();
		$_voucher_product = Tbl_voucher_has_product::where('voucher_id', $voucher_id)->product()->get();
		$data['_voucher_product'] = $_voucher_product;
		$data['account'] = $account;
		$data['voucher'] = $voucher;
		// dd($_voucher_product);

		return view('member.voucher_product', $data);
	}










}