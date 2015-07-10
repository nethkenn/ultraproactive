<?php namespace App\Http\Controllers;

class MemberDashboardController extends MemberController
{
	public function index()
	{
        return view('member.dashboard');
	}
}