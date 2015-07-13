<?php namespace App\Http\Controllers;

class MemberProductController extends MemberController
{
	public function index()
	{
        return view('member.product');
	}
}