<?php namespace App\Http\Controllers;

class MemberLeadController extends MemberController
{
	public function index()
	{
        return view('member.lead');
	}
}