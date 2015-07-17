<?php namespace App\Http\Controllers;

use App\Tbl_voucher;
use App\Tbl_voucher_has_product;
use Request;
class MemberVoucherController extends MemberController
{
	public function index()
	{

		$data['voucher'] = Tbl_voucher::all();



        return view('member.voucher' , $data);
	}
}