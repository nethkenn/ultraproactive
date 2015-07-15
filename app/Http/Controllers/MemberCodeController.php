<?php namespace App\Http\Controllers;

class MemberCodeController extends MemberController
{
	public function index()
	{
        return view('member.code_vault');
	}
}