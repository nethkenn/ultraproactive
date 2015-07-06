<?php namespace App\Http\Controllers;

class MemberController extends Controller
{
	public function index()
	{
        return view('member.dashboard');
	}
	public function code_vault()
	{
        return view('member.code_vault');
	}
}