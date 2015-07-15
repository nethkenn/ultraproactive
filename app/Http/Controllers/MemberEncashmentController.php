<?php namespace App\Http\Controllers;

class MemberEncashmentController extends MemberController
{
	public function index()
	{
        return view('member.encashment');
	}
}