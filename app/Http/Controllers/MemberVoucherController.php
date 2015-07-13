<?php namespace App\Http\Controllers;

class MemberVoucherController extends MemberController
{
	public function index()
	{
        return view('member.voucher');
	}
}