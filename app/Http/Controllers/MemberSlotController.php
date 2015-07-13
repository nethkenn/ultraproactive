<?php namespace App\Http\Controllers;

class MemberSlotController extends MemberController
{
	public function index()
	{
        return view('member.slot');
	}
}