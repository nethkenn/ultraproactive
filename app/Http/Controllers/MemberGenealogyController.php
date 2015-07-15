<?php namespace App\Http\Controllers;

class MemberGenealogyController extends MemberController
{
	public function index()
	{
        return view('member.genealogy');
	}
}