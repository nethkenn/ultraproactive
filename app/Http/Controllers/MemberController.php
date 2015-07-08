<?php namespace App\Http\Controllers;

class MemberController extends Controller
{
	public function index()
	{
        return view('member.dashboard');
	}
	public function slot()
	{
        return view('member.slot');
	}
	public function code_vault()
	{
        return view('member.code_vault');
	}
	public function encashment()
	{
        return view('member.encashment');
	}
	public function genealogy()
	{
        return view('member.genealogy');
	}
	public function voucher()
	{
        return view('member.voucher');
	}
	public function lead()
	{
        return view('member.lead');
	}
	public function product()
	{
        return view('member.product');
	}
}